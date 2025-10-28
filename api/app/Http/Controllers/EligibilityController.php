<?php

namespace App\Http\Controllers;

use App\Models\EligibilityModel;
use Illuminate\Http\Request;

class EligibilityController extends Controller
{
    public function displayEligibility(){
        $displayEligibility = EligibilityModel::all();

        return response()->json($displayEligibility);
    }
    public function displayInformation($id){
        $displayList = EligibilityModel::where('applicant_i_information_id','=', $id)->first();
        return response()->json($displayList);
    }

    public function storeEligibility(Request $request){
        $eligibilityField = $request -> validate([
            'applicant_i_information_id' => 'integer|required',
            'eligibility' => 'string|required',
        ]);
        $eligibilityField['is_active'] = '1';

        $eligibilityData = EligibilityModel::create($eligibilityField);

        return response()->json(['Store Eligibility Success', $eligibilityData], 201);
    }
    public function updateEligibility(Request $request, $id)
    {
        $EligibilityField = $request->validate([
            'eligibility' => 'string|required',
        ]);

        $eligibility = EligibilityModel::find($id);

        if (!$eligibility) {
            return response()->json(['message' => 'Eligibility not found'], 404);
        }

        $eligibility->update($EligibilityField);

        return response()->json(['message' => 'Eligibility updated successfully', 'data' => $eligibility], 200);
    }
}
