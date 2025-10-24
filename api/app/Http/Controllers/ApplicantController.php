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

    public function reApplyFunction(Request $request)
    {
        $fname  = $request->input('fname');
        $lname  = $request->input('lname');
        $bdate  = $request->input('bdate');
        $number = $request->input('number');

        $lookup = ApplicantModel::where('firstname', $fname)
            ->where('lastname', $lname)
            ->where('birthdate', $bdate)
            ->where('contactnumber', $number)
            ->orderBy('applicant_i_information_id', 'desc')
            ->first();

        if ($lookup) {
            return response()->json([
                'status' => 'found',
                'applicant' => $lookup
            ]);
        } else {
            return response()->json([
                'status' => 'not_found',
                'message' => 'No applicant matched the provided details.'
            ]);
        }
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
            'blood_type' => 'string|nullable',
            'gender' => 'string|nullable',
            'nickname' => 'string|nullable',
            'desiredPosition' => 'string|required',
        ]);

        $applicantField['is_active'] = '1';

        $applicationFieldsInformation = ApplicantModel::create($applicantField);
        return response()->json(['Applicant Record Submitted', $applicationFieldsInformation],201);
    }
}
