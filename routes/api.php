<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\RolesApiController;
use App\Http\Controllers\Api\Admin\UsersApiController;
use App\Http\Controllers\Api\Admin\PermissionsApiController;

use App\Http\Controllers\Api\Auth\AuthController;




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

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');



// Route::group(['middleware' => 'auth:api'], function () {

    Route::get('roles', [RolesApiController::class, 'index']);
    Route::post('addrole', [RolesApiController::class, 'addrole']);
    Route::delete('deleterole/{id}', [RolesApiController::class, 'deleterole']);

    Route::get('users', [UsersApiController::class, 'index']);
    Route::post('adduser', [UsersApiController::class, 'adduser']);
    Route::delete('deleteuser/{id}', [UsersApiController::class, 'deleteuser']);

    Route::get('permissions', [PermissionsApiController::class, 'index']);
// });









Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
