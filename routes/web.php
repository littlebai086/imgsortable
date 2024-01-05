<?php

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

Route::resource('/subjectdate',        'SubjectDateController');
Route::put('/subjectdate/test/{id}', 'SubjectDateController@update');

Route::get('/subjectdate/{id}/editimgsort',        'SubjectDateController@editimgsort');
Route::post('/subjectdate/group/saveorder',        'SubjectDateController@saveorder');

Route::resource('/dataenable',        'DataEnableController');
Route::post('/dataenable/dataenable_enable',        'DataEnableController@dataenable_enable');
// Route::resource('/editor',        'EditorController');
// Route::post('/editor/upload',        'EditorController@upload');
Route::resource('/dataeditor',        'DataEditorController');
Route::post('/dataeditor/upload',        'DataEditorController@upload');

Route::get('/googledrive/upload',        'GoogleDriveController@index');
Route::post('/googledrive/upload',        'GoogleDriveController@uploadFile');
