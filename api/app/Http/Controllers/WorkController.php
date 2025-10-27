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
        $displayList = workModel::where('applicant_i_information_id', $id)->latest('work_i_information_id')->first();
        return response()->json($displayList);
    }
    public function displayAllInformation($id){
        $displayList = workModel::where('applicant_i_information_id', $id)->get();
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
    public function updateExperience(Request $request, $id)
    {
        $ExperienceField = $request->validate([
            'companyname' => 'string|nullable',
            'workduration' => 'string|nullable',
            'reasonforleaving' => 'string|nullable',
            'position' => 'string|nullable',
            'previouscompensation' => 'integer|nullable',
            'contribution' => 'string|nullable',
        ]);

        $experience = workModel::find($id);

        if (!$experience) {
            return response()->json(['message' => 'Work experience not found'], 404);
        }

        $experience->update($ExperienceField);

        return response()->json(['message' => 'Work experience updated successfully', 'data' => $experience], 200);
    }

    public function Home(){
        return view('contact');
    }
}
