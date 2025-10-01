<?php

namespace App\Http\Controllers;

use App\Models\MarriageModel;
use Illuminate\Http\Request;

class MarriageController extends Controller
{
    public function displayMarriage(){
        $displayMarriage = MarriageModel::all();

        return response()->json($displayMarriage);
    }

    public function displayInformation($id){
        $displayList = MarriageModel::where('applicant_i_information_id','=', $id)->first();
        return response()->json($displayList);
    }

    public function storeMarriageInfo(Request $request){
        $MarriageField = $request->validate([
            'applicant_i_information_id' => 'integer',
            'partnerReligion' => 'string|nullable',
            'dateMarried' => 'string|nullable',
            'child' => 'string|nullable',
            'numberofchildren' => 'integer|nullable',
            'ageofchildren' => 'string|nullable',
            'guardianofchildren' => 'string|nullable',
        ]);
        
        $MarriageField['is_active'] = '1';

        $MarriageData = MarriageModel::create($MarriageField);

        return response()->json(['Marriage Information Added' , $MarriageData], 201);
    }
}
