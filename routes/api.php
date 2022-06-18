<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [App\Http\Controllers\API\Auth\AuthController::class, 'register']);
Route::post('/login', [App\Http\Controllers\API\Auth\AuthController::class, 'login']);
Route::post('/logout', [App\Http\Controllers\API\Auth\AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/getoffice', [App\Http\Controllers\OfficeController::class, 'getOffice']);
    Route::get('get-document-type', [App\Http\Controllers\DocumentTypeController::class, 'getDocumentType']);
    Route::resource('office', App\Http\Controllers\OfficeController::class);
    Route::resource('document-type', App\Http\Controllers\DocumentTypeController::class);
    Route::resource('document', App\Http\Controllers\DocumentController::class);
    Route::resource('role', App\Http\Controllers\roleController::class);
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::post('/update-user/{id}', [App\Http\Controllers\API\Auth\AuthController::class, 'update_user']);
    Route::delete('/remove-user/{id}', [App\Http\Controllers\API\Auth\AuthController::class, 'remove_user']);

    Route::resource('expenses-category', App\Http\Controllers\ExpensesCategoryController::class);
    Route::resource('expenses', App\Http\Controllers\MyExpensesController::class);
});
