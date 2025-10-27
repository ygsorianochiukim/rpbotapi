<?php

namespace App\Http\Controllers;

use App\Models\ApplicantModel;
use App\Models\ApplicantStatusModel;
use App\Models\EducationModel;
use App\Models\EligibilityModel;
use App\Models\MarriageModel;
use App\Models\workModel;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    public function displayInformation($id){
        $displayInformation = ApplicantModel::where('applicant_i_information_id' , $id);
        return response()->json($displayInformation);
    }
    public function displayEligibility($id){
        $displayEligibility = EligibilityModel::where('applicant_i_information_id' , $id);
        return response()->json($displayEligibility);
    }
    public function displayEducation($id){
        $displayEducation = EducationModel::where('applicant_i_information_id' , $id);
        return response()->json($displayEducation);
    }
    public function displayMarriage($id){
        $displayMarriage = MarriageModel::where('applicant_i_information_id' , $id);
        return response()->json($displayMarriage);
    }
    public function displayExperience($id){
        $displayExperience = workModel::where('applicant_i_information_id' , $id);
        return response()->json($displayExperience);
    }
    public function displayStatus($id){
        $displayStatus = ApplicantStatusModel::where('applicant_i_information_id' , $id);
        return response()->json($displayStatus);
    }
}
