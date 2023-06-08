<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', [\App\Http\Controllers\Web\DashboardController::class, 'index'])->name('dashboard');

    //Department
    Route::get('/department', [\App\Http\Controllers\Web\DepartmentController::class, 'index'])->name('department');
    Route::post('/department/getData', [\App\Http\Controllers\Web\DepartmentController::class, 'getData'])->name('department/getData');
    Route::post('/department/store', [\App\Http\Controllers\Web\DepartmentController::class, 'store'])->name('department/store');
    Route::get('/department/show/{id}', [\App\Http\Controllers\Web\DepartmentController::class, 'show'])->name('department/show');
    Route::post('/department/update', [\App\Http\Controllers\Web\DepartmentController::class, 'update'])->name('department/update');
    Route::post('/department/delete/{id}', [\App\Http\Controllers\Web\DepartmentController::class, 'destroy'])->name('department/delete');

    //Role
    Route::get('/role', [\App\Http\Controllers\Web\RoleController::class, 'index'])->name('role');
    Route::post('/role/getData', [\App\Http\Controllers\Web\RoleController::class, 'getData'])->name('role/getData');
    Route::get('/role/create', [\App\Http\Controllers\Web\RoleController::class, 'create'])->name('role/create');
    Route::post('/role/create', [\App\Http\Controllers\Web\RoleController::class, 'store'])->name('role/create');
    Route::get('/role/edit/{id}', [\App\Http\Controllers\Web\RoleController::class, 'edit'])->name('role/edit');
    Route::post('/role/edit/{id}', [\App\Http\Controllers\Web\RoleController::class, 'update'])->name('role/edit');
    Route::post('/role/delete/{id}', [\App\Http\Controllers\Web\RoleController::class, 'destroy'])->name('role/delete');

    //User
    Route::get('/user', [\App\Http\Controllers\Web\UserController::class, 'index'])->name('user');
    Route::post('/user/getData', [\App\Http\Controllers\Web\UserController::class, 'getData'])->name('user/getData');
    Route::get('/user/create', [\App\Http\Controllers\Web\UserController::class, 'create'])->name('user/create');
    Route::post('/user/create', [\App\Http\Controllers\Web\UserController::class, 'store'])->name('user/create');
    Route::get('/user/show/{id}', [\App\Http\Controllers\Web\UserController::class, 'show'])->name('user/show');
    Route::get('/user/edit/{id}', [\App\Http\Controllers\Web\UserController::class, 'edit'])->name('user/edit');
    Route::post('/user/update', [\App\Http\Controllers\Web\UserController::class, 'update'])->name('user/update');
    Route::post('/user/password', [\App\Http\Controllers\Web\UserController::class, 'changePassword'])->name('user/password');
    Route::post('/user/send/{id}', [\App\Http\Controllers\Web\UserController::class, 'send'])->name('user/send');
    Route::post('/user/delete/{id}', [\App\Http\Controllers\Web\UserController::class, 'destroy'])->name('user/delete');
    Route::post('/user/updateActive', [\App\Http\Controllers\Web\UserController::class, 'updateActive'])->name('user/updateActive');

    //Standard
    Route::get('/standard', [\App\Http\Controllers\Web\StandardController::class, 'index'])->name('standard');
    Route::post('/standard/getData', [\App\Http\Controllers\Web\StandardController::class, 'getData'])->name('standard/getData');
    Route::post('/standard/store', [\App\Http\Controllers\Web\StandardController::class, 'store'])->name('standard/store');
    Route::get('/standard/show/{id}', [\App\Http\Controllers\Web\StandardController::class, 'show'])->name('standard/show');
    Route::post('/standard/update', [\App\Http\Controllers\Web\StandardController::class, 'update'])->name('standard/update');
    Route::post('/standard/delete/{id}', [\App\Http\Controllers\Web\StandardController::class, 'destroy'])->name('standard/delete');

    //Organization
    Route::get('/organization', [\App\Http\Controllers\Web\OrganizationController::class, 'index'])->name('organization');
    Route::post('/organization/getData', [\App\Http\Controllers\Web\OrganizationController::class, 'getData'])->name('organization/getData');
    Route::get('/organization/create', [\App\Http\Controllers\Web\OrganizationController::class, 'create'])->name('organization/create');
    Route::post('/organization/create', [\App\Http\Controllers\Web\OrganizationController::class, 'store'])->name('organization/create');

    // Route::get('/user/show/{id}', [\App\Http\Controllers\Web\UserController::class, 'show'])->name('user/show');
    // Route::get('/user/edit/{id}', [\App\Http\Controllers\Web\UserController::class, 'edit'])->name('user/edit');
    // Route::post('/user/update', [\App\Http\Controllers\Web\UserController::class, 'update'])->name('user/update');

    Route::get('/organization/show/{id}', [\App\Http\Controllers\Web\OrganizationController::class, 'show'])->name('organization/show');
    Route::get('/organization/edit/{id}', [\App\Http\Controllers\Web\OrganizationController::class, 'edit'])->name('organization/edit');
    Route::post('/organization/update', [\App\Http\Controllers\Web\OrganizationController::class, 'update'])->name('organization/update');

    Route::post('/organization/delete/{id}', [\App\Http\Controllers\Web\OrganizationController::class, 'destroy'])->name('organization/delete');

    //FileExtension
    Route::post('/file-extension/getData', [\App\Http\Controllers\Web\FileExtensionController::class, 'getData'])->name('file-extension/getData');

    //Document Type
    Route::get('/document-type', [\App\Http\Controllers\Web\DocumentTypeController::class, 'index'])->name('document-type');
    Route::post('/document-type/getData', [\App\Http\Controllers\Web\DocumentTypeController::class, 'getData'])->name('document-type/getData');
    Route::get('/document-type/getDataActive', [\App\Http\Controllers\Web\DocumentTypeController::class, 'getDataActive'])->name('document-type/getDataActive');
    Route::post('/document-type/store', [\App\Http\Controllers\Web\DocumentTypeController::class, 'store'])->name('document-type/store');
    Route::post('/document-type/update', [\App\Http\Controllers\Web\DocumentTypeController::class, 'update'])->name('document-type/update');
    Route::get('/document-type/{id}', [\App\Http\Controllers\Web\DocumentTypeController::class, 'show'])->name('document-type');
    Route::post('/document-type/delete/{id}', [\App\Http\Controllers\Web\DocumentTypeController::class, 'destroy'])->name('document-type/delete');

    //Internal Audit
    Route::get('/internal-audit', [\App\Http\Controllers\Web\InternalAuditController::class, 'index'])->name('internal-audit');
    Route::post('/internal-audit/getData', [\App\Http\Controllers\Web\InternalAuditController::class, 'getData'])->name('internal-audit/getData');
    Route::any('/internal-audit/dt', [\App\Http\Controllers\Web\InternalAuditController::class, 'dt'])->name('internal-audit/dt');
    Route::get('/internal-audit/create', [\App\Http\Controllers\Web\InternalAuditController::class, 'create'])->name('internal-audit/create');
    Route::post('/internal-audit/create', [\App\Http\Controllers\Web\InternalAuditController::class, 'store'])->name('internal-audit/create');
    Route::get('/internal-audit/show/{id}', [\App\Http\Controllers\Web\InternalAuditController::class, 'show'])->name('internal-audit/show');
    Route::get('/internal-audit/detail/{id}', [\App\Http\Controllers\Web\InternalAuditController::class, 'detail'])->name('internal-audit/detail');
    Route::get('/internal-audit/edit/{id}', [\App\Http\Controllers\Web\InternalAuditController::class, 'edit'])->name('internal-audit/edit');
    Route::post('/internal-audit/update', [\App\Http\Controllers\Web\InternalAuditController::class, 'update'])->name('internal-audit/update');
    Route::post('/internal-audit/delete/{id}', [\App\Http\Controllers\Web\InternalAuditController::class, 'destroy'])->name('internal-audit/delete');

    //Schecule
    Route::get('schedule/{id}', [\App\Http\Controllers\Web\ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedule/getData', [\App\Http\Controllers\Web\ScheduleController::class, 'getData'])->name('schedule/getData');
    Route::any('/schedule/dt/{id}', [\App\Http\Controllers\Web\ScheduleController::class, 'dt'])->name('schedule/dt');
    Route::post('/schedule/store', [\App\Http\Controllers\Web\ScheduleController::class, 'store'])->name('schedule/store');
    Route::get('/schedule/show/{id}', [\App\Http\Controllers\Web\ScheduleController::class, 'show'])->name('schedule/show');
    Route::post('/schedule/update', [\App\Http\Controllers\Web\ScheduleController::class, 'update'])->name('schedule/update');
    Route::post('/schedule/delete/{id}', [\App\Http\Controllers\Web\ScheduleController::class, 'destroy'])->name('schedule/delete');

    //Instrument
    Route::get('instrument/{id}', [\App\Http\Controllers\Web\InstrumentController::class, 'index'])->name('instrument');
    Route::post('/instrument/getData', [\App\Http\Controllers\Web\InstrumentController::class, 'getData'])->name('instrument/getData');
    Route::any('/instrument/dt/{id}', [\App\Http\Controllers\Web\InstrumentController::class, 'dt'])->name('instrument/dt');
    Route::post('/instrument/store', [\App\Http\Controllers\Web\InstrumentController::class, 'store'])->name('instrument/store');
    Route::get('/instrument/show/{id}', [\App\Http\Controllers\Web\InstrumentController::class, 'show'])->name('instrument/show');
    Route::post('/instrument/update', [\App\Http\Controllers\Web\InstrumentController::class, 'update'])->name('instrument/update');
    Route::post('/instrument/delete/{id}', [\App\Http\Controllers\Web\InstrumentController::class, 'destroy'])->name('instrument/delete');

    //Finding
    Route::get('finding/{id}', [\App\Http\Controllers\Web\FindingController::class, 'index'])->name('finding');
    Route::post('/finding/getData', [\App\Http\Controllers\Web\FindingController::class, 'getData'])->name('finding/getData');
    Route::get('/finding/dt/{id}', [\App\Http\Controllers\Web\FindingController::class, 'dt'])->name('finding/dt');
    Route::post('/finding/store', [\App\Http\Controllers\Web\FindingController::class, 'store'])->name('finding/store');
    Route::get('/finding/show/{id}', [\App\Http\Controllers\Web\FindingController::class, 'show'])->name('finding/show');
    Route::post('/finding/update', [\App\Http\Controllers\Web\FindingController::class, 'update'])->name('finding/update');
    Route::post('/finding/delete/{id}', [\App\Http\Controllers\Web\FindingController::class, 'destroy'])->name('finding/delete');

    //Issue
    Route::get('/issue', [\App\Http\Controllers\Web\IssueController::class, 'index'])->name('issue');
    Route::post('/issue/getDataInternal', [\App\Http\Controllers\Web\IssueController::class, 'getDataInternal'])->name('issue/getDataInternal');
    Route::post('/issue/getDataExternal', [\App\Http\Controllers\Web\IssueController::class, 'getDataExternal'])->name('issue/getDataExternal');
    Route::any('/issue/dt/{id}', [\App\Http\Controllers\Web\IssueController::class, 'dt'])->name('issue/dt');
    Route::post('/issue/store', [\App\Http\Controllers\Web\IssueController::class, 'store'])->name('issue/store');
    Route::get('/issue/show/{id}', [\App\Http\Controllers\Web\IssueController::class, 'show'])->name('issue/show');
    Route::post('/issue/update', [\App\Http\Controllers\Web\IssueController::class, 'update'])->name('issue/update');
    Route::post('/issue/delete/{id}', [\App\Http\Controllers\Web\IssueController::class, 'destroy'])->name('issue/delete');

    //Document
    Route::get('/document', [\App\Http\Controllers\Web\DocumentController::class, 'index'])->name('document');
    Route::get('/document/child/{id}', [\App\Http\Controllers\Web\DocumentController::class, 'child'])->name('document/child');
    Route::post('/document/getData', [\App\Http\Controllers\Web\DocumentController::class, 'getData'])->name('document/getData');
    Route::post('/document/getDataRecycle', [\App\Http\Controllers\Web\DocumentController::class, 'getDataRecycle'])->name('document/getDataRecycle');
    Route::post('/document/store', [\App\Http\Controllers\Web\DocumentController::class, 'store'])->name('document/store');
    Route::post('/document/update', [\App\Http\Controllers\Web\DocumentController::class, 'update'])->name('document/update');
    Route::post('/document/archive', [\App\Http\Controllers\Web\DocumentController::class, 'archive'])->name('document/archive');
    Route::get('/document/{id}', [\App\Http\Controllers\Web\DocumentController::class, 'show'])->name('document/show');
    Route::get('/document/download/{id}', [\App\Http\Controllers\Web\DocumentController::class, 'download'])->name('document/download');
    Route::get('/document/stream/{id}', [\App\Http\Controllers\Web\DocumentController::class, 'stream'])->name('document/stream');
    Route::post('/document/delete/{id}', [\App\Http\Controllers\Web\DocumentController::class, 'destroy'])->name('document/delete');
    Route::post('/document/restore/{id}', [\App\Http\Controllers\Web\DocumentController::class, 'restore'])->name('document/restore');
    Route::get('/document/child/{id}', [\App\Http\Controllers\Web\DocumentController::class, 'child'])->name('document/child');
    Route::get('/document/export/{id}', [\App\Http\Controllers\Web\DocumentController::class, 'export'])->name('document/export');

    //Document Archive
    Route::get('/document-archive', [\App\Http\Controllers\Web\DocumentArchiveController::class, 'index'])->name('document-archive');
    Route::post('/document-archive/getData', [\App\Http\Controllers\Web\DocumentArchiveController::class, 'getData'])->name('document-archive/getData');
    Route::get('/document-archive/download/{id}', [\App\Http\Controllers\Web\DocumentArchiveController::class, 'download'])->name('document-archive/download');
    Route::get('/document-archive/stream/{id}', [\App\Http\Controllers\Web\DocumentArchiveController::class, 'stream'])->name('document-archive/stream');

    //Folder
    Route::post('/folder/getData', [\App\Http\Controllers\Web\FolderController::class, 'getData'])->name('folder/getData');
    Route::post('/folder/getDataChild', [\App\Http\Controllers\Web\FolderController::class, 'getDataChild'])->name('folder/getDataChild');
    Route::post('/folder/getDataRecycle', [\App\Http\Controllers\Web\FolderController::class, 'getDataRecycle'])->name('folder/getDataRecycle');
    Route::post('/folder/store', [\App\Http\Controllers\Web\FolderController::class, 'store'])->name('folder/store');
    Route::post('/folder/update', [\App\Http\Controllers\Web\FolderController::class, 'update'])->name('folder/update');
    Route::get('/folder/{id}', [\App\Http\Controllers\Web\FolderController::class, 'show'])->name('folder/show');
    Route::post('/folder/delete/{id}', [\App\Http\Controllers\Web\FolderController::class, 'destroy'])->name('folder/delete');
    Route::post('/folder/restore/{id}', [\App\Http\Controllers\Web\FolderController::class, 'restore'])->name('folder/restore');
    Route::get('/folder/export/document', [\App\Http\Controllers\Web\FolderController::class, 'export'])->name('folder/export');

    //Recycle
    Route::get('/recycle', [\App\Http\Controllers\Web\RecycleController::class, 'index'])->name('recycle');

    //Profile
    Route::get('/profile', [\App\Http\Controllers\Web\ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/show/{id}', [\App\Http\Controllers\Web\ProfileController::class, 'show'])->name('profile/show');
    Route::post('/profile/update', [\App\Http\Controllers\Web\ProfileController::class, 'update'])->name('profile/update');
    Route::post('/profile/password', [\App\Http\Controllers\Web\ProfileController::class, 'changePassword'])->name('profile/password');

    //Meeting Type
    Route::get('/meeting-type', [\App\Http\Controllers\Web\MeetingTypeController::class, 'index'])->name('meeting-type');
    Route::post('/meeting-type/getData', [\App\Http\Controllers\Web\MeetingTypeController::class, 'getData'])->name('meeting-type/getData');
    Route::post('/meeting-type/store', [\App\Http\Controllers\Web\MeetingTypeController::class, 'store'])->name('meeting-type/store');
    Route::post('/meeting-type/update', [\App\Http\Controllers\Web\MeetingTypeController::class, 'update'])->name('meeting-type/update');
    Route::get('/meeting-type/{id}', [\App\Http\Controllers\Web\MeetingTypeController::class, 'show'])->name('meeting-type/show');
    Route::post('/meeting-type/delete/{id}', [\App\Http\Controllers\Web\MeetingTypeController::class, 'destroy'])->name('meeting-type/delete');

    //Meeting
    Route::get('/meeting', [\App\Http\Controllers\Web\MeetingController::class, 'index'])->name('meeting');
    Route::post('/meeting/getData', [\App\Http\Controllers\Web\MeetingController::class, 'getData'])->name('meeting/getData');
    Route::get('/meeting/mom/{id}', [\App\Http\Controllers\Web\MeetingController::class, 'mom'])->name('meeting/mom');
    Route::post('/meeting/store', [\App\Http\Controllers\Web\MeetingController::class, 'store'])->name('meeting/store');
    Route::post('/meeting/update', [\App\Http\Controllers\Web\MeetingController::class, 'update'])->name('meeting/update');
    Route::get('/meeting/show/{id}', [\App\Http\Controllers\Web\MeetingController::class, 'show'])->name('meeting/show');
    Route::post('/meeting/delete/{id}', [\App\Http\Controllers\Web\MeetingController::class, 'destroy'])->name('meeting/delete');
    Route::get('/meeting/download/{id}', [\App\Http\Controllers\Web\MeetingController::class, 'download'])->name('meeting/download');
    Route::post('/meeting/finish/{id}', [\App\Http\Controllers\Web\MeetingController::class, 'finish'])->name('meeting/finish');
    Route::get('/meeting/action/{id}', [\App\Http\Controllers\Web\MeetingController::class, 'action'])->name('meeting/action');
    Route::post('/meeting/action', [\App\Http\Controllers\Web\MeetingController::class, 'saveAction'])->name('meeting/action');
    Route::post('/meeting/send/{id}', [\App\Http\Controllers\Web\MeetingController::class, 'send'])->name('meeting/send');

    //Meeting Attendee
    Route::post('/meeting-attendee/getData', [\App\Http\Controllers\Web\MeetingAttendeeController::class, 'getData'])->name('meeting-attendee/getData');
    Route::post('/meeting-attendee/store', [\App\Http\Controllers\Web\MeetingAttendeeController::class, 'store'])->name('meeting-attendee/store');
    Route::post('/meeting-attendee/update', [\App\Http\Controllers\Web\MeetingAttendeeController::class, 'update'])->name('meeting-attendee/update');
    Route::get('/meeting-attendee/{id}', [\App\Http\Controllers\Web\MeetingAttendeeController::class, 'show'])->name('meeting-attendee/show');
    Route::post('/meeting-attendee/delete/{id}', [\App\Http\Controllers\Web\MeetingAttendeeController::class, 'destroy'])->name('meeting-attendee/delete');

    //Meeting Detail
    Route::post('/meeting-detail/getData', [\App\Http\Controllers\Web\MeetingDetailController::class, 'getData'])->name('meeting-detail/getData');
    Route::post('/meeting-detail/store', [\App\Http\Controllers\Web\MeetingDetailController::class, 'store'])->name('meeting-detail/store');
    Route::post('/meeting-detail/update', [\App\Http\Controllers\Web\MeetingDetailController::class, 'update'])->name('meeting-detail/update');
    Route::get('/meeting-detail/{id}', [\App\Http\Controllers\Web\MeetingDetailController::class, 'show'])->name('meeting-detail/show');
    Route::post('/meeting-detail/delete/{id}', [\App\Http\Controllers\Web\MeetingDetailController::class, 'destroy'])->name('meeting-detail/delete');
    Route::post('/meeting-detail/action/info', [\App\Http\Controllers\Web\MeetingDetailController::class, 'infoAction'])->name('meeting-detail/action/info');
});

require __DIR__ . '/auth.php';
