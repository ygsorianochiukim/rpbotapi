<?php

namespace App\Http\Controllers;

use App\Models\ApplicantModel;
use Illuminate\Http\Request;

class MappingController extends Controller
{
    public function displayInformation($id){
        $displayInformation = ApplicantModel::where('applicant_i_information_id' , $id);
        return response()->json($displayInformation);
    }
}
