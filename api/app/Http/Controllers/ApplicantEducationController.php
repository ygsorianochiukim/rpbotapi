<?php

namespace App\Http\Controllers;

use App\Models\EducationModel;
use Illuminate\Http\Request;

class ApplicantEducationController extends Controller
{
    public function displayEducation(){
        $displayEducationInformation = EducationModel::all();

        return response()->json($displayEducationInformation);
    }

    public function storeEducation(Request $request){
        $educationField = $request -> validate([
            'applicant_i_information_id' => 'integer|required',
            'college' => 'string|required',
            'course' => 'string|required',
            'yeargraduate' => 'integer|required',
            'graduateschool' => 'integer|required',
            'boardexam' => 'string|required',
        ]);

        $educationField['is_active'] = '1';

        $educationData = EducationModel::create($educationField);

        return response()->json(['Education Added Success', $educationData], 201);
    }
}
