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
        $educationField['is_active'] = '1';

        $educationData = EducationModel::create($educationField);

        return response()->json(['Education Added Success', $educationData], 201);
    }
}
