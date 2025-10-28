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
    public function displayInformation($id){
        $displayList = EducationModel::where('applicant_i_information_id','=', $id)->first();
        return response()->json($displayList);
    }

    public function storeEducation(Request $request){
        $educationField = $request->validate([
            'applicant_i_information_id' => 'integer',
            'college' => 'string|nullable',
            'course' => 'string|nullable',
            'yeargraduate' => 'integer|nullable',
            'graduateschool' => 'integer|nullable',
            'boardexam' => 'string|nullable',
        ]);

        $educationField['is_active'] = '1';

        $educationData = EducationModel::create($educationField);

        return response()->json(['Education Added Success', $educationData], 201);
    }
    public function updateEducation(Request $request, $id)
    {
        $educationField = $request->validate([
            'applicant_i_information_id' => 'integer',
            'college' => 'string|nullable',
            'course' => 'string|nullable',
            'yeargraduate' => 'integer|nullable',
            'graduateschool' => 'integer|nullable',
            'boardexam' => 'string|nullable',
        ]);

        $Education = EducationModel::find($id);

        if (!$Education) {
            return response()->json(['message' => 'Education not found'], 404);
        }

        $Education->update($educationField);

        return response()->json(['message' => 'Education updated successfully', 'data' => $Education], 200);
    }
}
