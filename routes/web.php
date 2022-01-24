<?php

use App\Http\Controllers\FolderController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\FileController;
use App\Models\Folder;
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

Route::get('/', [PageController::class, 'index']);
Route::get('/folders/{id}', [FolderController::class, 'getOneFolder']);
Route::post('/files/upload', [FileController::class, 'uploadFile']);
