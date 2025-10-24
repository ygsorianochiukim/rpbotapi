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

    public function storeApplicationStatus(Request $request)
    {
        $validated = $request->validate([
            'applicant_i_information_id' => 'nullable|integer',
            'pendingapplication' => 'nullable|string',
            'lockincontract' => 'nullable|string',
            'motorcycle' => 'nullable|string',
            'license' => 'nullable|string',
            'technicalSkills' => 'nullable|string',
            'question' => 'nullable|string',
            'potfolio_link' => 'nullable|url',
            'filename' => 'nullable|string',
            'file_content' => 'nullable|string',
        ]);

        $validated['is_active'] = 1;
        if (!empty($validated['file_content'])) {
            $validated['potfolio_link'] = null;
        }
        else if (!empty($validated['potfolio_link'])) {
            $validated['filename'] = null;
            $validated['file_content'] = null;
        }

        $ApplicationData = ApplicantStatusModel::create($validated);

        return response()->json([
            'message' => 'Applicant status stored successfully',
            'data' => $ApplicationData,
        ], 201);
    }
}
