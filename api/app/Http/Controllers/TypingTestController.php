<?php

namespace App\Http\Controllers;

use App\Models\typingTest;
use Illuminate\Http\Request;

class TypingTestController extends Controller
{
    public function displayTypingTest(){
        $displayTypingTest = typingTest::all();

        return response()->json($displayTypingTest);
    }

    public function displayInformation($id){
        $displayList = typingTest::where('applicant_i_information_id','=', $id)->latest()->first();
        return response()->json($displayList);
    }

    public function storeTyping(Request $request){
        $TypingField = $request -> validate([
            'applicant_i_information_id' => 'integer|required',
            'wpm' => 'required',
            'accuracy' => 'required',
        ]);
        $TypingField['is_active'] = '1';

        $TypingData = typingTest::create($TypingField);

        return response()->json(['Store Typing Test Success', $TypingData], 201);
    }
}
