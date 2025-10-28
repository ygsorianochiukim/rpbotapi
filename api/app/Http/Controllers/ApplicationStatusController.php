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

        $ApplicationData = ApplicantStatusModel::create($validated);

        return response()->json([
            'message' => 'Applicant status stored successfully',
            'data' => $ApplicationData,
        ], 201);
    }
    public function updateStatus(Request $request, $id)
    {
        $StatusField = $request->validate([
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

        $Status = ApplicantStatusModel::find($id);

        if (!$Status) {
            return response()->json(['message' => 'Status not found'], 404);
        }

        $Status->update($StatusField);

        return response()->json(['message' => 'Status updated successfully', 'data' => $Status], 200);
    }
}
