<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\CsrfCookieController;
use App\Http\Controllers\PosTagController;
use App\Http\Controllers\Translation\ChineseWordController;
use App\Http\Controllers\Translation\DictionaryController;
use App\Http\Controllers\Translation\VietnameseWordController;
use App\Http\Controllers\WordSynonymController;
use Illuminate\Http\Request;
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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('api')->group(function () {
    Route::get('csrf-cookie', [CsrfCookieController::class, 'show']);

    Route::post('/login', [LoginController::class, 'login']);

    Route::middleware('auth')->group(function () {
        Route::get('/me', function (Request $request) {
            return response()->json($request->user());
        });

        Route::delete('/logout', [LogoutController::class, 'logout']);

        Route::apiResource('dictionary', DictionaryController::class);

        Route::get('vietnamese/find', [VietnameseWordController::class, 'findByTextAndType']);
        Route::get('chinese/find', [ChineseWordController::class, 'findByTextAndType']);

        Route::get('vietnamese/meanings/{wordId}', [VietnameseWordController::class, 'getMeanings']);
        Route::get('chinese/meanings/{wordId}', [ChineseWordController::class, 'getMeanings']);

        Route::get('vietnamese/posTags/{wordId}', [VietnameseWordController::class, 'getPosTags']);
        Route::get('chinese/posTags/{wordId}', [ChineseWordController::class, 'getPosTags']);

        Route::put('vietnamese/{wordId}/restore', [VietnameseWordController::class, 'restore']);
        Route::put('chinese/{wordId}/restore', [ChineseWordController::class, 'restore']);

        Route::apiResource('chinese', ChineseWordController::class);
        Route::apiResource('vietnamese', VietnameseWordController::class);
        Route::apiResource('synonym', WordSynonymController::class);
        Route::get('posTag', [PosTagController::class, 'index']);
    });
});
