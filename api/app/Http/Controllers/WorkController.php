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

    public function displayInformation($id){
        $displayList = workModel::where('applicant_i_information_id','=', $id)->first();
        return response()->json($displayList);
    }

    public function storeExperience(Request $request){
        $ExperienceField = $request -> validate([
            'applicant_i_information_id' => 'integer|nullable',
            'companyname' => 'string|nullable',
            'workduration' => 'string|nullable',
            'reasonforleaving' => 'string|nullable',
            'position' => 'string|nullable',
            'previouscompensation' => 'integer|nullable',
            'contribution' => 'string|nullable',
        ]);

        $ExperienceField['is_active'] = '1';

        $experienceData = workModel::create($ExperienceField);

        return response()->json(['New Experience Added', $experienceData], 201);
    }

    public function Home(){
        return view('contact');
    }
}
