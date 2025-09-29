<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message,
            'care' => $request->care,
            'discipline' => $request->discipline,
            'mastery' => $request->mastery,
            'wpm' => $request->wpm,
            'accuracy' => $request->accuracy,
            'score' => $request->score,
            'applicant' => $request->applicant,
            'applicantID' => $request->applicantID,
        ];

        Mail::to($request->email)->send(new ContactMail($details));

        return response()->json(['message' => 'Email sent successfully!']);
    }
}
