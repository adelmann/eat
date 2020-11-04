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
    if($user = Auth::user())
    {
        return redirect('/home');
        //return view('home');
    } else {
        return redirect('/login');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/owntimes', 'owntimes@index')->name('owntimes');
Route::get('/owntimes/delete/{id}', 'owntimes@delete')->name('deleteEntry');
Route::get('/owntimes/edit/{id}', 'owntimes@edit')->name('editEntry');

Route::get('/addtime', 'addtime@index')->name('addtime');
Route::post('/addtime/addnew', 'addtime@addnew')->name('addnewtime');
Route::post('/addtime/updateEntry', 'addtime@updateEntry')->name('updateEntry');

Route::get('/export', 'export@index')->name('export');
Route::get('/export/kindergardenYear', 'export@kindergardenYear')->name('exportKindergardenYear');
Route::get('/export/exportKindergardenMonth', 'export@exportKindergardenMonth')->name('exportKindergardenMonth');
Route::get('/export/exportKindergardenYearParents', 'export@exportKindergardenYearParents')->name('exportKindergardenYearParents');
Route::post('/export/range', 'export@exportRange')->name('exportRange');

//admin
Route::get('/adminuser', 'admin@adminuser')->name('adminuser');
