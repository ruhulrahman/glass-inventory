<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommonAjaxController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
	'as'=>'api.v1.',
	'prefix'=>'v1',
	'namespace'=>'Api\V1'
], function(){


    Route::prefix('admin')->namespace('Admin')->as('admin.')->group(
	    __DIR__.'/api/admin.php'
	);

	Route::get('common-ajax/{name}', [CommonAjaxController::class, 'get'])->name('common-ajax-get');
	Route::post('common-ajax/{name}', [CommonAjaxController::class, 'post'])->name('common-ajax-post');

});
