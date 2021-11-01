<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UploadController;

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


####################################
# Upload
####################################
Route::post('/upload', [UploadController::class, 'upload']);    



####################################
# Users - sample extend routes per entity
####################################
// Route::prefix('/users')->group(function(){
//     Route::get('/{user_id}', [UserController::class, 'show']);    
// }); 
