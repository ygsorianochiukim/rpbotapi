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
        $ApplicationStatusField = $request->validate([
            'applicant_i_information_id' => 'nullable|integer',
            'pendingapplication' => 'nullable|string',
            'lockincontract' => 'nullable|string',
            'motorcycle' => 'nullable|string',
            'license' => 'nullable|string',
            'technicalSkills' => 'nullable|string',
            'question' => 'nullable|string',
        ]);

        $ApplicationStatusField['is_active'] = '1';

        $ApplicationData = ApplicantStatusModel::create($ApplicationStatusField);
        return response()->json(['Store Applicant Status', $ApplicationData],201);
    }
}
