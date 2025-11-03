<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicantEducationController;
use App\Http\Controllers\ApplicationStatusController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\EligibilityController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\IQTestController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MarriageController;
use App\Http\Controllers\TypingTestController;
use App\Http\Controllers\WorkController;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/applicant',[ApplicantController::class,'listApplication']);
Route::post('/applicant',[ApplicantController::class,'newApplicant']);
Route::post('/applicant/lookup', [ApplicantController::class, 'reApplyFunction']);

Route::get('/applicantEducation',[ApplicantEducationController::class,'displayEducation']);
Route::post('/applicantEducation',[ApplicantEducationController::class,'storeEducation']);
Route::put('/applicantEducation/update/{id}', [ApplicantEducationController::class, 'updateEducation']);

Route::get('/applicantionStatus',[ApplicationStatusController::class,'displayApplicationStatus']);
Route::post('/applicantionStatus',[ApplicationStatusController::class,'storeApplicationStatus']);
Route::put('/applicantionStatus/update/{id}', [ApplicationStatusController::class, 'updateStatus']);
Route::put('/applicantionStatus/updateportfolio/{id}', [ApplicationStatusController::class, 'updatePortfolio']);

Route::get('/applicantEligibility',[EligibilityController::class,'displayEligibility']);
Route::post('/applicantEligibility',[EligibilityController::class,'storeEligibility']);
Route::put('/applicantEligibility/update/{id}', [EligibilityController::class, 'updateEligibility']);

Route::get('/applicantMarriage',[MarriageController::class,'displayMarriage']);
Route::post('/applicantMarriage',[MarriageController::class,'storeMarriageInfo']);
Route::put('/applicantMarriage/update/{id}', [MarriageController::class, 'updateMarriage']);

Route::get('/applicantExperience',[WorkController::class,'displayWorkExperience']);
Route::post('/applicantExperience',[WorkController::class,'storeExperience']);
Route::put('/applicantExperience/update/{id}', [WorkController::class, 'updateExperience']);

Route::get('/wpm',[TypingTestController::class,'displayTypingTest']);
Route::post('/wpm',[TypingTestController::class,'storeTyping']);

Route::get('/IQ',[IQTestController::class,'displayIQTest']);
Route::post('/IQ',[IQTestController::class,'storeIQ']);

Route::post('/send-email', [MailController::class, 'sendMail']);

Route::post('/conversations', [ConversationController::class, 'store']);

Route::get('/applicant/{id}', [ApplicantController::class, 'displayInformation']);
Route::get('/applicantEducation/{id}', [ApplicantEducationController::class, 'displayInformation']);
Route::get('/applicationStatus/{id}', [ApplicationStatusController::class, 'displayInformation']);
Route::get('/eligibility/{id}', [EligibilityController::class, 'displayInformation']);
Route::get('/marriage/{id}', [MarriageController::class, 'displayInformation']);
Route::get('/workExperience/{id}', [WorkController::class, 'displayInformation']);
Route::get('/workExperienceall/{id}', [WorkController::class, 'displayAllInformation']);
Route::get('/wpm/{id}', [TypingTestController::class, 'displayInformation']);
Route::get('/iq/{id}', [IQTestController::class, 'displayInformation']);
Route::get('/conversations/{id}', [ConversationController::class, 'displayInformation']);

Route::post('/interview', [InterviewController::class, 'process']);
Route::post('/interview/handleInterview', [InterviewController::class, 'handleInterview']);
