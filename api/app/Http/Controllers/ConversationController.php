<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'applicant_i_information_id' => 'required|integer',
            'messages' => 'required|array',
        ]);

        $conversation = Conversation::create([
            'applicant_i_information_id' => $request->applicant_i_information_id,
            'messages' => $request->messages,
        ]);

        return response()->json([
            'success' => true,
            'conversation' => $conversation
        ]);
    }
}
