<?php

namespace App\Http\Controllers;

use App\Models\ApplicantInterviewModel;
use App\Models\ApplicantModel;
use App\Models\ApplicantStatusModel;
use App\Models\EducationModel;
use App\Models\EligibilityModel;
use App\Models\IQTest;
use App\Models\MarriageModel;
use App\Models\typingTest;
use App\Models\workModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * The seam to the Approvals desk, where the interview now happens.
 *
 * Two calls cross it and nothing else:
 *   open    — after the exams, hand the applicant over with everything the
 *             application holds; get back the one-time link they are sent to.
 *   verdict — Approvals writes back passed or failed when the MD releases it.
 *             This is what sends the applicant their SMS.
 * A third, status, lets the front end ask whether a verdict has landed.
 *
 * Settings (config/services.php → approvals): APPROVALS_URL, APPROVALS_INTAKE_TOKEN
 * (the bearer we present), APPROVALS_VERDICT_KEY (the key Approvals presents to us).
 */
class ApprovalsInterviewController extends Controller
{
    /** POST /interview/open  { applicant_i_information_id } → { url } */
    public function open(Request $request)
    {
        $data = $request->validate([
            'applicant_i_information_id' => 'required|integer',
        ]);
        $id = (int) $data['applicant_i_information_id'];

        $applicant = ApplicantModel::find($id);
        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found'], 404);
        }

        // One interview per applicant: asking twice returns the same link.
        $row = ApplicantInterviewModel::firstOrCreate(['applicant_i_information_id' => $id]);
        if ($row->interview_url) {
            return response()->json(['url' => $row->interview_url, 'reused' => true]);
        }

        $base = rtrim((string) config('services.approvals.url'), '/');
        $token = (string) config('services.approvals.intake_token');
        if (!$base || !$token) {
            return response()->json(['message' => 'The interview desk is not configured (APPROVALS_URL / APPROVALS_INTAKE_TOKEN).'], 503);
        }

        $payload = $this->intakePayload($applicant);

        try {
            $response = $this->http()
                ->withToken($token)
                ->acceptJson()
                ->post($base . '/api/intake', $payload);
        } catch (\Throwable $e) {
            Log::warning('ApprovalsInterview: intake unreachable', ['applicant' => $id, 'error' => $e->getMessage()]);
            return response()->json(['message' => 'Could not reach the interview desk. Please try again in a moment.'], 502);
        }

        if (!$response->successful() || !$response->json('url')) {
            Log::warning('ApprovalsInterview: intake refused', ['applicant' => $id, 'status' => $response->status(), 'body' => $response->body()]);
            return response()->json(['message' => 'The interview desk did not accept the application (' . $response->status() . ').'], 502);
        }

        $row->update([
            'interview_url' => $response->json('url'),
            'interview_id' => $response->json('id'),
        ]);

        return response()->json(['url' => $row->interview_url]);
    }

    /** GET /interview/status/{applicant_i_information_id} */
    public function status($id)
    {
        $row = ApplicantInterviewModel::where('applicant_i_information_id', (int) $id)->first();
        return response()->json([
            'verdict' => $row->verdict ?? 'pending',
            'verdict_at' => $row->verdict_at ?? null,
            'interview_url' => $row->interview_url ?? null,
        ]);
    }

    /**
     * PUT /interview/verdict/{applicant_i_information_id}
     * X-RPV-Key: <APPROVALS_VERDICT_KEY>
     * { verdict: passed|failed, verdict_at, verdict_by, verdict_note, verdict_ref, verdict_language }
     *
     * Idempotent: the same verdict arriving twice is acknowledged, not re-sent.
     */
    public function verdict(Request $request, $id)
    {
        $want = (string) config('services.approvals.verdict_key');
        $got = (string) $request->header('X-RPV-Key', '');
        if ($want === '' || !hash_equals($want, $got)) {
            return response()->json(['message' => 'Not authorised.'], 401);
        }

        $data = $request->validate([
            'verdict' => 'required|in:passed,failed',
            'verdict_at' => 'nullable|string',
            'verdict_by' => 'nullable|string',
            'verdict_note' => 'nullable|string',
            'verdict_ref' => 'nullable|string',
            'verdict_language' => 'nullable|string',
        ]);

        $applicant = ApplicantModel::find((int) $id);
        if (!$applicant) {
            return response()->json(['message' => 'Applicant not found'], 404);
        }

        $row = ApplicantInterviewModel::firstOrCreate(['applicant_i_information_id' => (int) $id]);
        if ($row->verdict === $data['verdict'] && $row->verdict_at) {
            return response()->json(['ok' => true, 'already' => true, 'verdict' => $row->verdict]);
        }
        if ($row->verdict !== 'pending') {
            // A verdict, once given, is not flipped by a second call: that is
            // the MD's to change, on the Approvals desk, deliberately.
            return response()->json(['message' => 'A verdict already stands for this applicant: ' . $row->verdict], 409);
        }

        $language = strtolower((string) ($data['verdict_language'] ?? $row->language ?? 'english'));
        $row->fill([
            'verdict' => $data['verdict'],
            'verdict_at' => $data['verdict_at'] ?? now(),
            'verdict_by' => $data['verdict_by'] ?? 'MD',
            'verdict_note' => $data['verdict_note'] ?? null,
            'verdict_ref' => $data['verdict_ref'] ?? null,
            'language' => $language,
        ])->save();

        // The applicant's SMS — the same messages this portal has always sent.
        $sms = $this->sendResultSms($applicant, $data['verdict'], $language);
        $row->update([
            'sms_sent_at' => $sms['ok'] ? now() : null,
            'sms_response' => json_encode($sms['response']),
        ]);

        return response()->json(['ok' => true, 'verdict' => $row->verdict, 'sms' => $sms['ok'] ? 'sent' : 'failed']);
    }

    // ── helpers ────────────────────────────────────────────────────────────

    /** Everything the application holds, for the interviewer and the MD. */
    private function intakePayload(ApplicantModel $a): array
    {
        $id = $a->applicant_i_information_id;
        $status = ApplicantStatusModel::where('applicant_i_information_id', $id)->first();
        $typing = typingTest::where('applicant_i_information_id', $id)->latest()->first();
        $iq = IQTest::where('applicant_i_information_id', $id)->latest()->first();

        $strip = fn ($m, array $drop) => $m ? collect($m->toArray())->except($drop)->all() : null;
        $rowsOf = fn ($q, array $drop) => $q->get()->map(fn ($m) => collect($m->toArray())->except($drop)->all())->values()->all();
        $meta = ['is_active', 'created_at', 'updated_at', 'applicant_i_information_id'];

        return [
            'ext_ref' => (string) $id,
            'candidate_name' => trim($a->firstname . ' ' . ($a->middlename ? $a->middlename . ' ' : '') . $a->lastname),
            'position' => $a->desiredPosition ?: 'Applicant',
            'phone' => $a->contactnumber,
            'email' => $a->email,
            'dossier' => [
                'profile' => [
                    'nickname' => $a->nickname,
                    'gender' => $a->gender,
                    'birthdate' => $a->birthdate,
                    'civil_status' => $a->civilStatus,
                    'religion' => $a->religion,
                    'address' => trim(implode(', ', array_filter([$a->barangay, $a->cities, $a->province, $a->zipcode]))),
                    'expected_salary' => $a->expectedSalary,
                ],
                'typing_test' => $typing ? ['wpm' => $typing->wpm, 'accuracy' => $typing->accuracy] : null,
                'iq_test' => $iq ? ['score' => $iq->score] : null,
                'education' => $strip(EducationModel::where('applicant_i_information_id', $id)->first(), array_merge($meta, ['education_i_information_id'])),
                'eligibility' => $strip(EligibilityModel::where('applicant_i_information_id', $id)->first(), array_merge($meta, ['eligibility_i_id'])),
                'marriage' => $strip(MarriageModel::where('applicant_i_information_id', $id)->first(), array_merge($meta, ['marriage_i_information_id'])),
                'work_experience' => $rowsOf(workModel::where('applicant_i_information_id', $id), array_merge($meta, ['work_i_information_id'])),
                'screening' => $status ? [
                    'pending_application' => $status->pendingapplication,
                    'lock_in_contract' => $status->lockincontract,
                    'motorcycle' => $status->motorcycle,
                    'license' => $status->license,
                    'technical_skills' => $status->technicalSkills,
                    'applicant_question' => $status->question,
                    'portfolio' => $status->potfolio_link ?: $status->filename,
                ] : null,
            ],
        ];
    }

    private function sendResultSms(ApplicantModel $a, string $verdict, string $language): array
    {
        $position = $a->desiredPosition ?: 'position you applied for';
        if ($verdict === 'passed') {
            $message = "Good day. Thank you for applying for the $position at Renaissance Park and Chapels. Congratulations and welcome. You have been accepted. Our team will be in touch shortly to walk you through the employment details and onboarding process. We’re happy to have you join us.";
        } elseif ($language === 'tagalog') {
            $message = "Magandang araw. Maraming salamat sa iyong interes sa posisyon na $position sa Renaissance Park and Chapels. Base sa aming paunang pagsusuri, ang iyong aplikasyon ay hindi nakasunod sa mga kinakailangang pamantayan. Sa ilang pagkakataon, nagsasagawa ang aming team ng muling pagsusuri. Kapag napili ang iyong profile para dito, makikipag-ugnayan kami sa iyo nang direkta. Maraming salamat sa oras na inilaan mo sa pag-apply.";
        } elseif ($language === 'ilonggo') {
            $message = "Maayong adlaw. Madamo guid nga salamat sa imo interes sa posisyon nga $position sa Renaissance Park and Chapels. Base sa amon paunang pag-review, ang imo aplikasyon indi nag-satisfy sang kinahanglanon nga pamantayan. Sa pila ka kaso, naga-conduct man ang amon team sang liwat nga reevaluation. Kon mapilian ang imo profile para sini, kami mismo ang magakontak sa imo. Salamat guid sa imo tion kag interes sa pag-apply.";
        } else {
            $message = "Good day. Thank you for your interest in the $position at Renaissance Park and Chapels. Based on our initial review, your application did not meet the required criteria. In certain cases, our team conducts a subsequent reevaluation. If your profile is selected for that, we will contact you directly. Thank you for taking the time to apply.";
        }

        try {
            $response = $this->http(30)
                ->asForm()
                ->post('https://semaphore.co/api/v4/messages', [
                    'apikey' => env('SEMAPHORE_API_KEY'),
                    'number' => $a->contactnumber,
                    'message' => $message,
                    'sendername' => env('SEMAPHORE_SENDER_NAME'),
                ]);
            return ['ok' => $response->successful(), 'response' => $response->json() ?? $response->body()];
        } catch (\Throwable $e) {
            Log::warning('ApprovalsInterview: result SMS failed', ['applicant' => $a->applicant_i_information_id, 'error' => $e->getMessage()]);
            return ['ok' => false, 'response' => $e->getMessage()];
        }
    }

    /**
     * Outbound HTTP, through the same proxy the SMS sender has always used.
     * OUTBOUND_PROXY overrides it; set it empty to go direct.
     */
    private function http(int $timeout = 20)
    {
        $proxy = config('services.approvals.proxy');
        $options = ['timeout' => $timeout];
        if ($proxy) {
            $options['proxy'] = $proxy;
        }
        return Http::withOptions($options);
    }
}
