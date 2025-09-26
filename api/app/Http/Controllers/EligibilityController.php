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

    public function storeEligibility(Request $request){
        $eligibilityField = $request -> validate([
            'applicant_i_information_id' => 'integer|required',
            'eligibility' => 'string|required',
        ]);
        $eligibilityField['is_active'] = '1';

        $eligibilityData = EligibilityModel::create($eligibilityField);

        return response()->json(['Store Eligibility Success', $eligibilityData], 201);
    }


}
