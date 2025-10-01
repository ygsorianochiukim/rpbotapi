<?php

namespace App\Http\Controllers;

use App\Models\ApplicantModel;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function listApplication(){
        $displayList = ApplicantModel::all();
        return response()->json($displayList);
    }
    public function displayInformation($id){
        $displayList = ApplicantModel::where('applicant_i_information_id','=', $id)->first();
        return response()->json($displayList);
    }

    public function newApplicant(Request $request){
        $applicantField = $request -> validate([
            'firstname' => 'string|required',
            'middlename' => 'string|nullable',
            'lastname' => 'string|required',
            'email' => 'string|required',
            'civilStatus' => 'string|required',
            'contactnumber' => 'string|required',
            'birthdate' => 'date|required',
            'religion' => 'string|required',
            'province' => 'string|required',
            'cities' => 'string|required',
            'barangay' => 'string|required',
            'zipcode' => 'integer|required',
            'expectedSalary' => 'integer|required',
        ]);

        $applicantField['is_active'] = '1';

        $applicationFieldsInformation = ApplicantModel::create($applicantField);
        return response()->json(['Applicant Record Submitted', $applicationFieldsInformation],201);
    }
}
