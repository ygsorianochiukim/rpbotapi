<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function displayInformation($id){
        $displayList = Conversation::where('applicant_i_information_id','=', $id)->orderBy('applicant_i_conversation_id','desc')->first();
        return response()->json($displayList);
    }
    public function store(Request $request)
    {
        $request->validate([
            'applicant_i_information_id' => 'required|integer',
            'messages' => 'required|array',
            'care' => 'required|integer',
            'ambition' => 'required|integer',
            'influence' => 'required|integer',
            'skillsDevelopment' => 'required|integer',
            'technicalSkills' => 'required|integer',
            'discipline' => 'required|integer',
            'commentary' => 'required|string',
        ]);

        $conversation = Conversation::create([
            'applicant_i_information_id' => $request->applicant_i_information_id,
            'messages' => $request->messages,
            'care' => $request->care,
            'influence' => $request->influence,
            'ambition' => $request->ambition,
            'skillsDevelopment' => $request->skillsDevelopment,
            'technicalSkills' => $request->technicalSkills,
            'discipline' => $request->discipline,
            'commentary' => $request->commentary,
        ]);

        return response()->json([
            'success' => true,
            'conversation' => $conversation
        ]);
    }
}
