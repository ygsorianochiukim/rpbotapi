<?php

namespace App\Http\Controllers;

use App\Models\IQTest;
use Illuminate\Http\Request;

class IQTestController extends Controller
{
    public function displayIQTest(){
        $displayIqTest = IQTest::all();

        return response()->json($displayIqTest);
    }

    public function displayInformation($id){
        $displayList = IQTest::where('applicant_i_information_id', $id)->latest()->first();
        return response()->json($displayList);
    }

    public function storeIQ(Request $request){
        $IqField = $request -> validate([
            'applicant_i_information_id' => 'integer|required',
            'score' => 'required',
        ]);
        
        $IqField['is_active'] = '1';

        $IQData = IQTest::create($IqField);

        return response()->json(['Store IQ Test Success', $IQData], 201);
    }
}
