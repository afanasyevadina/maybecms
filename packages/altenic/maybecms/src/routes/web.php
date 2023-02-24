<?php

use Altenic\MaybeCms\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Auth;
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

Route::any('/maybecms/{any?}', function () {
    return view('maybecms::index');
})->where('any', '.*');

Route::get('/', [SiteController::class, 'index']);
Route::get('/{slug}', [SiteController::class, 'page']);
