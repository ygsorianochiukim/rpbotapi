<?php

namespace App\Http\Controllers;

use App\Models\ApplicantStatusModel;
use Illuminate\Http\Request;

class ApplicationStatusController extends Controller
{
    public function displayApplicationStatus(){
        $displayStatus = ApplicantStatusModel::all();

        return response()->json($displayStatus);
    }
    public function displayInformation($id){
        $displayList = ApplicantStatusModel::where('applicant_i_information_id','=', $id)->first();
        return response()->json($displayList);
    }

    public function storeApplicationStatus(Request $request){
        $ApplicationStatusField = $request -> validate([
            'applicant_i_information_id' => 'integer|required',
            'contribution' => 'string|required',
            'pendingapplication' => 'string|required',
            'lockincontract' => 'string|required',
            'motorcycle' => 'string|required',
            'license' => 'string|required',
            'technicalSkills' => 'string|required',
            'question' => 'string|required',
            'dateAvailability' => 'date|required',
        ]);

        $ApplicationStatusField['is_active'] = '1';

        $ApplicationData = ApplicantStatusModel::create($ApplicationStatusField);
        return response()->json(['Store Applicant Status', $ApplicationData],201);
    }
}
