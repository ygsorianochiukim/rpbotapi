<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use OpenAI;
use Illuminate\Support\Facades\Storage;

class InterviewController extends Controller
{
    public function process(Request $request)
    {
        if (!$request->hasFile('audio')) {
            return response()->json(['error' => 'No audio file provided.'], 400);
        }
        $guzzle = new Client([
            'proxy' => [
                'http'  => 'http://mis:c%40sp3r2021@10.7.7.121:3128',
                'https' => 'http://mis:c%40sp3r2021@10.7.7.121:3128',
            ],
        ]);

        $client = OpenAI::factory()
            ->withApiKey(env('OPENAI_API_KEY'))
            ->withHttpClient($guzzle)
            ->make();
        $audio = $request->file('audio');
        $path = $audio->store('temp', 'private');
        $filePath = storage_path("app/private/$path");

        $transcription = $client->audio()->transcribe([
            'model' => 'whisper-1',
            'file'  => fopen($filePath, 'r'),
        ]);

        $text = $transcription->text ?? '';

        $aiResponse = $client->chat()->create([
            'model' => 'gpt-4o-mini',
            'messages' => [
                ['role' => 'system', 'content' => 'You are a professional interviewer asking clear follow-up questions.'],
                ['role' => 'user', 'content' => $text],
            ],
        ]);

        $reply = $aiResponse->choices[0]->message->content ?? 'Could not generate response.';
        $tts = $client->audio()->speech([
            'model'  => 'gpt-4o-mini-tts',
            'voice'  => 'alloy',
            'input'  => $reply,
            'format' => 'mp3',
        ]);
        $voiceData = base64_encode($tts);
        Storage::disk('private')->delete($path);
        return response()->json([
            'transcription' => $text,
            'text'  => $reply,
            'voice' => $voiceData,
        ]);
    }
}
