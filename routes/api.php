<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/', [App\Http\Controllers\UserController::class, 'index']);

Route::group(['middleware' => ['auth:api']], function() {
    
    // Admin Routes
    
    // User Routes
    Route::get('/user', [App\Http\Controllers\UserController::class, 'user']);
    
    Route::get('/user/get', [App\Http\Controllers\UserController::class, 'get']);

    Route::get('/user/get/selected', [App\Http\Controllers\UserController::class, 'selected']);

    Route::post('/team/add', [App\Http\Controllers\UserController::class, 'add']);

    Route::post('/team/update', [App\Http\Controllers\UserController::class, 'update']);

    Route::get('/team/delete', [App\Http\Controllers\UserController::class, 'delete']);

    Route::get('/department/user', [App\Http\Controllers\DepartmentController::class, 'users']);

    // Incident Routes

    Route::post('/incident/type/add', [App\Http\Controllers\IncidentController::class, 'addType']);

    // Project Routes

    Route::get('/project/get', [App\Http\Controllers\ProjectController::class, 'get']);

    Route::post('/project/add', [App\Http\Controllers\ProjectController::class, 'add']);

    Route::get('/pages/project/get', [App\Http\Controllers\ProjectController::class, 'projectList']);

    Route::get('/project/get/selected', [App\Http\Controllers\ProjectController::class, 'selected']);

    Route::post('/project/update', [App\Http\Controllers\ProjectController::class, 'update']);

    Route::get('/project/delete', [App\Http\Controllers\ProjectController::class, 'delete']);

    Route::get('/project/filter/job', [App\Http\Controllers\ProjectController::class, 'filterJob']);

    Route::get('/project/get/count', [App\Http\Controllers\ProjectController::class, 'count']);

    // Manpower Routes

    Route::post('/manpower/add', [App\Http\Controllers\ManpowerController::class, 'add']);

    Route::get('/manpower/get', [App\Http\Controllers\ManpowerController::class, 'get']);

    Route::get('/manpower/get/selected', [App\Http\Controllers\ManpowerController::class, 'selected']);

    Route::post('/manpower/update', [App\Http\Controllers\ManpowerController::class, 'update']);

    Route::get('/manpower/delete', [App\Http\Controllers\ManpowerController::class, 'delete']);

    Route::get('/manpower/company/type', [App\Http\Controllers\ManpowerController::class, 'type']);

    Route::get('/manpower/filter/job', [App\Http\Controllers\ManpowerController::class, 'filterJob']);

    Route::get('/manpower/get/count', [App\Http\Controllers\ManpowerController::class, 'count']);

    //Data Management
    
    // HSE

    //QA

    Route::get('/qa/form/get/all', [App\Http\Controllers\QAController::class, 'all']);

    // QA Routes

    Route::get('/qa/get/statistics', [App\Http\Controllers\QAController::class, 'statistics']);

    Route::get('/qa/get/project/statistics', [App\Http\Controllers\QAController::class, 'projectStatistics']);

    Route::post('/qa/form/add', [App\Http\Controllers\QAController::class, 'add']);
    
    Route::get('/qa/form/get', [App\Http\Controllers\QAController::class, 'get']);

    Route::get('/qa/form/mobile/get', [App\Http\Controllers\QAController::class, 'getMobileData']);

    Route::get('/qa/form/get/selected', [App\Http\Controllers\QAController::class, 'selected']);

    Route::post('/qa/form/update', [App\Http\Controllers\QAController::class, 'update']);

    Route::get('/qa/form/delete', [App\Http\Controllers\QAController::class, 'delete']);

    Route::get('/qa/form/filter/serial', [App\Http\Controllers\QAController::class, 'filterSerial']);

    Route::get('/qa/form/filter/duration', [App\Http\Controllers\QAController::class, 'filterDuration']);

    Route::get('/qa/form/get/count', [App\Http\Controllers\QAController::class, 'count']);
    
    // HSE Routes

    // HSE Module Form Routes

    // Man Hour Routes

    Route::post('/hse/module/manhours/add', [App\Http\Controllers\HSEModule\ManHourController::class, 'add']);

    Route::get('/hse/module/manhours/get', [App\Http\Controllers\HSEModule\ManHourController::class, 'get']);

    Route::get('/hse/module/manhours/get/selected', [App\Http\Controllers\HSEModule\ManHourController::class, 'selected']);

    Route::post('/hse/module/manhours/update', [App\Http\Controllers\HSEModule\ManHourController::class, 'update']);

    // Man Day Routes

    Route::post('/hse/module/mandays/add', [App\Http\Controllers\HSEModule\ManDayController::class, 'add']);

    Route::get('/hse/module/mandays/get', [App\Http\Controllers\HSEModule\ManDayController::class, 'get']);

    Route::get('/hse/module/mandays/get/selected', [App\Http\Controllers\HSEModule\ManDayController::class, 'selected']);

    Route::post('/hse/module/mandays/update', [App\Http\Controllers\HSEModule\ManDayController::class, 'update']);

    // Near Misses Routes

    Route::post('/hse/module/near-miss/add', [App\Http\Controllers\HSEModule\NearMissesController::class, 'add']);

    Route::get('/hse/module/near-miss/get', [App\Http\Controllers\HSEModule\NearMissesController::class, 'get']);

    Route::get('/hse/module/near-miss/get/selected', [App\Http\Controllers\HSEModule\NearMissesController::class, 'selected']);

    Route::post('/hse/module/near-miss/update', [App\Http\Controllers\HSEModule\NearMissesController::class, 'update']);

    // First Aid Routes

    Route::post('/hse/module/first-aid/add', [App\Http\Controllers\HSEModule\FirstAidController::class, 'add']);

    Route::get('/hse/module/first-aid/get', [App\Http\Controllers\HSEModule\FirstAidController::class, 'get']);

    Route::get('/hse/module/first-aid/get/selected', [App\Http\Controllers\HSEModule\FirstAidController::class, 'selected']);

    Route::post('/hse/module/first-aid/update', [App\Http\Controllers\HSEModule\FirstAidController::class, 'update']);

    //Minor Injury Routes

    Route::post('/hse/module/minor-injury/add', [App\Http\Controllers\HSEModule\MinorInjuryController::class, 'add']);

    Route::get('/hse/module/minor-injury/get', [App\Http\Controllers\HSEModule\MinorInjuryController::class, 'get']);

    Route::get('/hse/module/minor-injury/get/selected', [App\Http\Controllers\HSEModule\MinorInjuryController::class, 'selected']);

    Route::post('/hse/module/minor-injury/update', [App\Http\Controllers\HSEModule\MinorInjuryController::class, 'update']);


    // LTI Routes

    Route::post('/hse/module/lti/add', [App\Http\Controllers\HSEModule\LTIController::class, 'add']);

    Route::get('/hse/module/lti/get', [App\Http\Controllers\HSEModule\LTIController::class, 'get']);

    Route::get('/hse/module/lti/get/selected', [App\Http\Controllers\HSEModule\LTIController::class, 'selected']);

    Route::post('/hse/module/lti/update', [App\Http\Controllers\HSEModule\LTIController::class, 'update']);

    // Manpower Routes
    
    Route::post('/hse/module/manpower/add', [App\Http\Controllers\HSEModule\HSEManpowerController::class, 'add']);

    Route::get('/hse/module/manpower/get', [App\Http\Controllers\HSEModule\HSEManpowerController::class, 'get']);

    Route::get('/hse/module/manpower/get/selected', [App\Http\Controllers\HSEModule\HSEManpowerController::class, 'selected']);

    Route::post('/hse/module/manpower/update', [App\Http\Controllers\HSEModule\HSEManpowerController::class, 'update']);

    // NCR Routes

    Route::post('/hse/module/ncr/add', [App\Http\Controllers\HSEModule\NCRController::class, 'add']);

    Route::get('/hse/module/ncr/get', [App\Http\Controllers\HSEModule\NCRController::class, 'get']);

    Route::get('/hse/module/ncr/get/selected', [App\Http\Controllers\HSEModule\NCRController::class, 'selected']);

    Route::post('/hse/module/ncr/update', [App\Http\Controllers\HSEModule\NCRController::class, 'update']);

    // NCR Routes

    Route::post('/hse/module/work-permit/add', [App\Http\Controllers\HSEModule\WorkPermitController::class, 'add']);

    Route::get('/hse/module/work-permit/get', [App\Http\Controllers\HSEModule\WorkPermitController::class, 'get']);

    Route::get('/hse/module/work-permit/get/selected', [App\Http\Controllers\HSEModule\WorkPermitController::class, 'selected']);

    Route::post('/hse/module/work-permit/update', [App\Http\Controllers\HSEModule\WorkPermitController::class, 'update']);

    // Induction Routes

    Route::post('/hse/module/induction/add', [App\Http\Controllers\HSEModule\InductionController::class, 'add']);

    Route::get('/hse/module/induction/get', [App\Http\Controllers\HSEModule\InductionController::class, 'get']);

    Route::get('/hse/module/induction/get/selected', [App\Http\Controllers\HSEModule\InductionController::class, 'selected']);

    Route::post('/hse/module/induction/update', [App\Http\Controllers\HSEModule\InductionController::class, 'update']);

    // TBT Routes

    Route::post('/hse/module/tbt/add', [App\Http\Controllers\HSEModule\TBTController::class, 'add']);

    Route::get('/hse/module/tbt/get', [App\Http\Controllers\HSEModule\TBTController::class, 'get']);

    Route::get('/hse/module/tbt/get/selected', [App\Http\Controllers\HSEModule\TBTController::class, 'selected']);

    Route::post('/hse/module/tbt/update', [App\Http\Controllers\HSEModule\TBTController::class, 'update']);

    // Meeting Routes

    Route::post('/hse/module/meeting/add', [App\Http\Controllers\HSEModule\MeetingController::class, 'add']);

    Route::get('/hse/module/meeting/get', [App\Http\Controllers\HSEModule\MeetingController::class, 'get']);

    Route::get('/hse/module/meeting/get/selected', [App\Http\Controllers\HSEModule\MeetingController::class, 'selected']);

    Route::post('/hse/module/meeting/update', [App\Http\Controllers\HSEModule\MeetingController::class, 'update']);

    // Issue Corrected Routes

    Route::post('/hse/module/issues-corrected/add', [App\Http\Controllers\HSEModule\IssueCorrectedController::class, 'add']);

    Route::get('/hse/module/issues-corrected/get', [App\Http\Controllers\HSEModule\IssueCorrectedController::class, 'get']);

    Route::get('/hse/module/issues-corrected/get/selected', [App\Http\Controllers\HSEModule\IssueCorrectedController::class, 'selected']);

    Route::post('/hse/module/issues-corrected/update', [App\Http\Controllers\HSEModule\IssueCorrectedController::class, 'update']);

    // Action Routes

    Route::post('/hse/module/action/add', [App\Http\Controllers\HSEModule\ActionController::class, 'add']);

    Route::get('/hse/module/action/get', [App\Http\Controllers\HSEModule\ActionController::class, 'get']);

    Route::get('/hse/module/action/get/selected', [App\Http\Controllers\HSEModule\ActionController::class, 'selected']);

    Route::post('/hse/module/action/update', [App\Http\Controllers\HSEModule\ActionController::class, 'update']);

    // Plan Routes

    Route::post('/hse/plan/add', [App\Http\Controllers\PlanController::class, 'add']);

    Route::get('/hse/plan/get', [App\Http\Controllers\PlanController::class, 'get']);

    Route::get('/hse/plan/get/selected', [App\Http\Controllers\PlanController::class, 'selected']);

    Route::post('/hse/plan/update', [App\Http\Controllers\PlanController::class, 'update']);

    // Other Routes

    // Edit Profile Picture

    Route::post('/profile/details/update', [App\Http\Controllers\ProfileController::class, 'update']);

    Route::post('/profile/picture/edit', [App\Http\Controllers\ProfileController::class, 'edit']);
});