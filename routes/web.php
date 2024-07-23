<?php

use App\Models\Sertifikat;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CalenderController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\DokumentasiController;
use App\Http\Controllers\SponsorshipController;
use App\Http\Controllers\EventLandingController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DocumentationController;
use App\Http\Controllers\LandingSistemController;
use App\Http\Controllers\SettingLayoutController;
use App\Http\Controllers\SubmissionEventController;
use App\Http\Controllers\SubmissionReportController;
use App\Http\Controllers\OrganizationLandingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// Landing Sistem
Route::get('/', [LandingSistemController::class, 'index'])->name('home');
Route::get('/about', [LandingSistemController::class, 'about'])->name('about');
Route::get('/event-all', [EventLandingController::class, 'index'])->name('eventAll');
Route::get('/landing-calendar', [LandingSistemController::class, 'landingCalendar'])->name('landingCalendar');

// Event
Route::get('/past-event', [LandingSistemController::class, 'pastEvent'])->name('pastEvent');
Route::get('/ongoing-event', [LandingSistemController::class, 'ongoingEvent'])->name('ongoingEvent');
Route::get('/upcoming-event', [LandingSistemController::class, 'upcomingEvent'])->name('upcomingEvent');
Route::get('/detail-event/{event}', [LandingSistemController::class, 'detailEvent'])->name('detailEvent');
Route::get('registration/{id}', [LandingSistemController::class, 'registration'])->name('registration');
Route::post('/process-registration', [RegistrationController::class, 'prosesRegistration'])->name('process-registration');
// Dokumentasi
Route::get('/detail-documentation/{id}', [LandingSistemController::class, 'detailDocumentation'])->name('detailDocumentation');
// Organisasi
Route::get('/landing-organization', [OrganizationLandingController::class, 'index'])->name('landingOrganization');
Route::get('/organization-event/{id}', [OrganizationLandingController::class, 'organizationEvent'])->name('organizationEvent');
Route::get('/organization-profil/{id}', [OrganizationLandingController::class, 'organizationProfil'])->name('organizationProfil');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // konfigurasi Organisasi, Users & role
    Route::prefix('configuration')->group(function () {
        Route::resource('role', RoleController::class);
        Route::resource('user', UserController::class)->except(['show']);
        Route::resource('organization', OrganizationController::class);
    });

    //  Category & Event
    Route::prefix('component')->group(function () {
        Route::resource('category', CategoryController::class);
        Route::resource('sponsorship', SponsorshipController::class);

        Route::resource('event', EventController::class);
        Route::get('event/download/proposal/{documentProposal}', [EventController::class, 'downloadProposal'])->name('component.downloadProposal');
        Route::get('event/download/rab/{documentRab}', [EventController::class, 'downloadRab'])->name('component.downloadRab');
        Route::get('event/edit-khusus/{event}/edit', [EventController::class, 'edit_khusus'])->name('edit_khusus_event');
        Route::put('event/edit-khusus/{event}', [EventController::class, 'update_khusus'])->name('update_khusus_event');
    });

    // Report
    Route::resource('report', ReportController::class);
    Route::get('report/edit-khusus/{report}/edit', [ReportController::class, 'edit_khusus'])->name('edit_khusus_report');
    Route::put('report/edit-khusus/{report}', [ReportController::class, 'update_khusus'])->name('update_khusus_report');
    Route::get('report/download/{document}', [ReportController::class, 'downloadReport'])->name('downloadReport');

    // Calendar
    Route::get('calendar', [CalenderController::class, 'index'])->name('calendar');

    // List Participation
    Route::resource('participant', RegistrationController::class);
    Route::get('participant/proof_payment/{id}', [RegistrationController::class, 'proof_payment']);
    Route::post('/check-registration', [RegistrationController::class, 'checkRegistration'])->name('checkRegistration');
    Route::get('participant/approve/{id}', [RegistrationController::class, 'approveRegistration'])->name('approveRegistration');

    // Export Excel
    Route::get('participant/exportExcel/{id}', [ExportController::class, 'exportExcel'])->name('exportExcel');
    Route::get('participant/exportPdf/{id}', [ExportController::class, 'exportPdf'])->name('exportPdf');

    // Upload Dokumentasi
    Route::get('participant/documentation/{id}', [DocumentationController::class, 'index'])->name('documentation');
    Route::post('participant/documentation/{id}', [DocumentationController::class, 'uploadDocumentation'])->name('uploadDocumentation');
    Route::get('participant/documentation/show/{id}', [DocumentationController::class, 'documentationShow'])->name('documentationShow');

    // Upload Sertifikat
    Route::get('participant/sertifikat/{id}', [SertifikatController::class, 'index'])->name('sertifikat');
    Route::post('participant/sertifikat/{id}', [SertifikatController::class, 'uploadSertifikat'])->name('uploadSertifikat');

    // Profil
    Route::get('profil', [ProfilController::class, 'index'])->name('profil');
    Route::put('profil-update', [ProfilController::class, 'update'])->name('profilUpdate');

    // Setting
    Route::get('setting', [SettingController::class, 'index'])->name('setting');
    Route::put('setting/{id}', [SettingController::class, 'update'])->name('settingUpdate');
});
