<?php

use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Factura\Controllers\FacturaController;
use App\Modules\Persona\Controllers\PersonaController;
use App\Modules\Role\Controllers\RoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::middleware('auth:sanctum')->group(function(){

    Route::post('/logout', [AuthController::class, 'logout']);

    //devuelve el usuario autenticado basado en el token
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Route::resource('/users', UserController::class);

    Route::resource('/roles', RoleController::class);
    Route::get('/permisos/{id}', [RoleController::class, 'getUserPermissions']);

    Route::resource('/personas', PersonaController::class);
    Route::post('/buscar', [PersonaController::class, 'findByDocumento']);

    Route::resource('/facturas', FacturaController::class);

});

