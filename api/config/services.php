<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    // The Approvals desk, where the applicant interview runs and the MD
    // releases the verdict. See ApprovalsInterviewController.
    'approvals' => [
        'url' => env('APPROVALS_URL', 'https://approvals.37-59-111-221.sslip.io'),
        'intake_token' => env('APPROVALS_INTAKE_TOKEN'),
        'verdict_key' => env('APPROVALS_VERDICT_KEY'),
        // Outbound proxy for Approvals and Semaphore calls. Defaults to the
        // proxy the SMS sender has always used; set OUTBOUND_PROXY= (empty) to go direct.
        'proxy' => env('OUTBOUND_PROXY', 'http://mis:c%40sp3r2021@10.7.7.121:3128'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

];
