<?php

use App\Http\Controllers\Api\v1\Admin\Authentication\AuthenticationController;
use App\Http\Controllers\Api\v1\Admin\Permissions\PermissionsController;
use App\Http\Controllers\Api\v1\Admin\Roles\RolesController;
use App\Http\Controllers\Api\v1\Admin\Users\UsersController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Paciente\PacienteController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas\SedesTomaMuestraController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas\EncuestaController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas\EstadosController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Ubicaciones\UbicacionController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Encuentas\TempLoteController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\FileUploader\PatientFileUploaderController;
use App\Http\Controllers\Api\v1\TomaMuestrasInv\Reportes\ReportesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|

Route::middleware(['auth:sanctum', 'verified'])
    ->get('/user', function (Request $request) {
        return $request->user();
    });

/** App Routes */
Route::prefix('/v1')->group(function () {

   Route::post('file/upload', [PatientFileUploaderController::class, 'store']);

   Route::middleware(['auth', 'verified'])->group(function () {

    /* ADMINISTRADOR*/

    /** Routes For User Management  */
    Route::get('users', [UsersController::class, 'getUsersList']);
    Route::post('users/store', [AuthenticationController::class, 'register']);
    Route::delete('user/inactivate/{id}', [UsersController::class, 'inactivateUserById']);
    Route::post('users/change-password', [UsersController::class, 'updatePassword']);
    Route::put('users/update/{userid}', [UsersController::class, 'updateUser']);

    /** Routes For Handle Permissions Management  */
    Route::get('permissions', [PermissionsController::class, 'getPermissionList']);
    Route::post('permissions/store', [PermissionsController::class, 'savePermission']);
    Route::delete('permissions/delete/{id}', [PermissionsController::class, 'inactivatePermissionById']);

    /** Routes For Handle Roles Management  */
    Route::get('roles', [RolesController::class, 'getRoleList']);
    Route::post('roles/store', [RolesController::class, 'saveRole']);
    Route::put('roles/edit/{id}', [RolesController::class, 'modifyRoleById']);
    Route::delete('roles/delete/{id?}', [RolesController::class, 'inactivateRoleById']);


    Route::post('mfa/user', [UsersController::class, 'sendCodeMFA']);
    Route::get('mfa/user/validate', [UsersController::class, 'validateCodeMFA']);


    /*--------------------------------------------------------------------------------*/

    /* PAISES - DEPARTAMENTOS - CIUDADES/MUNICIPIOS  */

    Route::get('geografia/getpais', [UbicacionController::class, 'getPais']);
    Route::get('geografia/getdepartamento/{pais_id}', [UbicacionController::class, 'getDepartamento']);
    Route::get('geografia/getciudad/{departamento_id}', [UbicacionController::class, 'getCiudad']);
    Route::get('geografia/getciudadforpaisid/{pais_id}', [UbicacionController::class, 'getCiudadesForPaisId']);

    Route::get('geografia/getallciudad', [UbicacionController::class, 'getAllCiudad']);
    Route::get('geografia/getalldepartamento', [UbicacionController::class, 'getAllDepartamento']);


    /* PACIENTE  */

    Route::post('/patient/post/createpatient', [PacienteController::class, 'createPatient']);
    Route::get('/patient/get/patient/{id?}', [PacienteController::class, 'getPatient']);
    Route::post('/patient/post/patientinformedconsent', [PacienteController::class, 'patientInformedConsent']);
    Route::get('/patient/get/patientinformedconsent/{paciente_id}', [PacienteController::class, 'getpatientInformedConsent']);
    Route::post('/patient/post/revokeinformedconsent', [PacienteController::class, 'revokeInformedConsent']);


    /*--------------------------------------------------------------------------------*/
    /* SEDES DE TOMA DE MUESTRAS */

    Route::get('/sedesmuestras/get/sedestomademuestras', [SedesTomaMuestraController::class, 'getSedesTomaMuestra']);
    Route::post('/sedesmuestras/post/sedestomademuestras', [SedesTomaMuestraController::class, 'AddSedesTomaMuestra']);

    /*--------------------------------------------------------------------------------*/
    /* ESTADOS */

    Route::get('/enfermedades/get/enfermedades/{code?}', [EncuestaController::class, 'getEnfermedadesci10']);
    Route::get('/enfermedades/get/oncologicas', [EncuestaController::class, 'getEnfermedadesci10Onco']);



    /*--------------------------------------------------------------------------------*/
    /* ESTADOS */

    Route::get('/estadosmuestras/get/estadosmuestras', [EstadosController::class, 'getEstadosMuestras']);

    /*--------------------------------------------------------------------------------*/
    /* ENCUESTA */

    Route::post('/encuesta/post/registrarencuesta', [EncuestaController::class, 'crearEncuesta']);
    Route::post('/encuesta/post/registrarinformacionhistoriaclinica', [EncuestaController::class, 'AgregarInformacionComplementaria']);
    Route::post('/encuesta/post/asignarmuestrasalote', [EncuestaController::class, 'crearAsignacionAutomaticaAlote']);
    Route::post('/encuesta/post/lotesentrasporte', [EncuestaController::class, 'lotesEntrasporte']);
    Route::post('/encuesta/post/lotemuestrasrecibidasbiobanco', [EncuestaController::class, 'muestrasEntregadasBioBanco']);
    Route::post('/encuesta/post/asignacionbiobanco', [EncuestaController::class, 'muestrasAsignadasAnevera']);
    Route::post('/encuesta/post/asignacionMuestrasEnvio', [EncuestaController::class, 'muestrasAsignadasAcajaEnvio']);
    Route::get('/encuesta/get/tempmuestrassponsorbox/{biobanco_id}', [EncuestaController::class, 'getTempoBoxSponsor']);
    Route::post('/encuesta/post/enviarmuestrassponsor', [EncuestaController::class, 'enviarMuestrasSponsor']);


    Route::get('/encuesta/get/encuestasporestado/{estado?}', [EncuestaController::class, 'trazabilidadEncuestas']);
    Route::get('/encuesta/get/estadosencuesta/{encuesta_id}', [EncuestaController::class, 'trazabilidadFlujoEstadosEncuesta']);
    Route::get('/encuesta/get/encuestassincrf', [EncuestaController::class, 'getEncuestasForCRF']);
    Route::get('/encuesta/get/respuestasencuestas/{encuesta_id}', [EncuestaController::class, 'respuestasEncuesta']);
    Route::get('/encuesta/get/informacionhistoriaclinica/{encuesta_id}', [EncuestaController::class, 'respuestasInformacionHistoriaClinica']);

    /*--------------------------------------------------------------------------------*/
    /* TEMP */

    Route::post('/encuesta/post/tempmuestras', [TempLoteController::class, 'guardarLoteTemp']);
    Route::get('/encuesta/get/tempmuestras/{user_id}/{sede_id}', [TempLoteController::class, 'getLoteTemp']);
    Route::post('/encuesta/delete/tempmuestras', [TempLoteController::class, 'deleteTemp']);

    /*--------------------------------------------------------------------------------*/
    /* DASHBOARD */

    Route::get('/encuesta/get/reportes/datadashboard', [ReportesController::class, 'getDataDashboard']);

   });

    /* ------------------------------------------------------------------------------------
    /** Clean Cache Route */
    Route::get('/clear', function () {
        Artisan::call('cache:clear');
        Artisan::call('route:clear');
        Artisan::call('config:clear');
        Artisan::call('view:clear');
   });

});
