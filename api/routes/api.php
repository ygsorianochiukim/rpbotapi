<?php

use App\Http\Controllers\ApplicantController;
use App\Http\Controllers\ApplicantEducationController;
use App\Http\Controllers\ApplicationStatusController;
use App\Http\Controllers\EligibilityController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\MarriageController;
use App\Http\Controllers\WorkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/applicant',[ApplicantController::class,'listApplication']);
Route::post('/applicant',[ApplicantController::class,'newApplicant']);

Route::get('/applicantEducation',[ApplicantEducationController::class,'displayEducation']);
Route::post('/applicantEducation',[ApplicantEducationController::class,'storeEducation']);

Route::get('/applicantionStatus',[ApplicationStatusController::class,'displayApplicationStatus']);
Route::post('/applicantionStatus',[ApplicationStatusController::class,'storeApplicationStatus']);

Route::get('/applicantEligibility',[EligibilityController::class,'displayEligibility']);
Route::post('/applicantEligibility',[EligibilityController::class,'storeEligibility']);

Route::get('/applicantMarriage',[MarriageController::class,'displayMarriage']);
Route::post('/applicantMarriage',[MarriageController::class,'storeMarriageInfo']);

Route::get('/applicantExperience',[WorkController::class,'displayWorkExperience']);
Route::post('/applicantExperience',[WorkController::class,'storeExperience']);

Route::post('/send-email', [MailController::class, 'sendMail']);