<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SMSOTPController extends Controller
{
    public function sendSMSOTP(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'otp' => 'required',
        ]);

        $proxy = "http://mis:c%40sp3r2021@10.7.7.121:3128";

        $response = Http::asForm()
            ->withOptions([
                'proxy' => $proxy,
                'timeout' => 30,
            ])
            ->post('https://semaphore.co/api/v4/messages', [
                'apikey' => env('SEMAPHORE_API_KEY'),
                'number' => $request->number,
                'message' => "Your verification OTP is: $request->otp",
                'sendername' => env('SEMAPHORE_SENDER_NAME'),
            ]);

        return response()->json([
            'success' => true,
            'semaphore_response' => $response->json()
        ]);
    }
    public function sendSMSConfirmation(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'status' => 'required',
            'position' => 'required',
            'language' => 'nullable'
        ]);

        if ($request->language == "english") {
            $message = "Good day. Thank you for your interest in the $request->position at Renaissance Park and Chapels. Based on our initial review, your application did not meet the required criteria. In certain cases, our team conducts a subsequent reevaluation. If your profile is selected for that, we will contact you directly. Thank you for taking the time to apply.";
        }
        else if ($request->language == "tagalog") {
            $message = "Magandang araw. Maraming salamat sa iyong interes sa posisyon na $request->position sa Renaissance Park and Chapels. Base sa aming paunang pagsusuri, ang iyong aplikasyon ay hindi nakasunod sa mga kinakailangang pamantayan. Sa ilang pagkakataon, nagsasagawa ang aming team ng muling pagsusuri. Kapag napili ang iyong profile para dito, makikipag-ugnayan kami sa iyo nang direkta. Maraming salamat sa oras na inilaan mo sa pag-apply.";
        }
        else if($request->language == "ilonggo"){
            $message = "Maayong adlaw. Madamo guid nga salamat sa imo interes sa posisyon nga $request->position sa Renaissance Park and Chapels. Base sa amon paunang pag-review, ang imo aplikasyon indi nag-satisfy sang kinahanglanon nga pamantayan. Sa pila ka kaso, naga-conduct man ang amon team sang liwat nga reevaluation. Kon mapilian ang imo profile para sini, kami mismo ang magakontak sa imo. Salamat guid sa imo tion kag interes sa pag-apply.";
        }
        else {
            $message = "Good day. Thank you for your interest in the $request->position at Renaissance Park and Chapels. Based on our initial review, your application did not meet the required criteria. In certain cases, our team conducts a subsequent reevaluation. If your profile is selected for that, we will contact you directly. Thank you for taking the time to apply.";
        }
        

        $proxy = "http://mis:c%40sp3r2021@10.7.7.121:3128";


        if ($request -> status == "Failed") {
            $response = Http::asForm()
                ->withOptions([
                    'proxy' => $proxy,
                    'timeout' => 30,
                ])
                ->post('https://semaphore.co/api/v4/messages', [
                    'apikey' => env('SEMAPHORE_API_KEY'),
                    'number' => $request->number,
                    'message' => $message,
                    'sendername' => env('SEMAPHORE_SENDER_NAME'),
                ]);

            return response()->json([
                'success' => true,
                'semaphore_response' => $response->json()
            ]);
        }
    }
    public function sendSMSConfirmationEvaluation(Request $request)
    {
        $request->validate([
            'number' => 'required',
            'status' => 'required',
            'position' => 'required'
        ]);

        if ($request->status == "Passed") {
            $message ="Good day. Thank you for applying for the $request->position at Renaissance Park and Chapels. Congratulations and welcome. You have been accepted. Our team will be in touch shortly to walk you through the employment details and onboarding process. We’re happy to have you join us.";
        }
        else{
            $message = "Good day. Thank you for your interest in the $request->position at Renaissance Park and Chapels. Based on our initial review, your application did not meet the required criteria. In certain cases, our team conducts a subsequent reevaluation. If your profile is selected for that, we will contact you directly. Thank you for taking the time to apply.";
        }

        $proxy = "http://mis:c%40sp3r2021@10.7.7.121:3128";

        $response = Http::asForm()
            ->withOptions([
                'proxy' => $proxy,
                'timeout' => 30,
            ])
            ->post('https://semaphore.co/api/v4/messages', [
                'apikey' => env('SEMAPHORE_API_KEY'),
                'number' => $request->number,
                'message' => $message,
                'sendername' => env('SEMAPHORE_SENDER_NAME'),
            ]);

        return response()->json([
            'success' => true,
            'semaphore_response' => $response->json()
        ]);
    }
}
