<?php

namespace App\Http\Controllers;

use App\Models\workModel;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function displayWorkExperience(){
        $ExperienceList = workModel::all();

        return response()->json($ExperienceList);
    }

    public function storeExperience(Request $request){
        $ExperienceField = $request -> validate([
            'applicant_i_information_id' => 'integer|required',
            'companyname' => 'string|required',
            'workduration' => 'string|required',
            'reasonforleaving' => 'string|required',
            'position' => 'string|required',
            'previouscompensation' => 'integer|required',
        ]);

        $ExperienceField['is_active'] = '1';

        $experienceData = workModel::create($ExperienceField);

        return response()->json(['New Experience Added', $experienceData], 201);
    }
}
