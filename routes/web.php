<?php

use Illuminate\Support\Facades\Route;
use App\Domains\User\Repositories\UserRepository;

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
Route::group(['middleware' => 'language'], function () {

  
   
   
    Route::get('/', [App\Http\Controllers\Public\HomePageController::class,'index'])->name('home-page');
    Route::get('/search', [App\Http\Controllers\Public\HomePageController::class,'search'])->name('search');
    Route::get('/check-certificate', [App\Http\Controllers\Public\HomePageController::class,'check_certificate'])->name('check-certificate');
    Route::get('/my-messages', [App\Http\Controllers\Public\HomePageController::class,'my_messages'])->name('my-messages');
    Route::get('/search', [App\Http\Controllers\Public\HomePageController::class,'search'])->name('search');
    Route::get('/cookie-policy', [App\Http\Controllers\Public\HomePageController::class,'cookie_policy'])->name('cookie-policy');


    

    //courses
    Route::resource('courses', App\Http\Controllers\Public\CoursesController::class);
    Route::get('/my-courses', [App\Http\Controllers\Public\CoursesController::class,'my_courses'])->name('my-courses');

  


    // Customer routes
    Route::group(['middleware' => 'auth:customer',], function () {
       
    });


    // Vendor routes
    Route::group(['middleware' => 'auth:vendor',], function () {
       
       
    });
    // dashboard routes
    Route::group(['middleware' => 'auth:web','auth:vendor'], function () {
        

        Route::get('/admin',[App\Http\Controllers\HomeController::class, 'index'])->name('admin');
        //user
        Route::resource('user', App\Http\Controllers\UserController::class);
        Route::get('/user-profile',[App\Http\Controllers\UserController::class, 'profile'])->name('user-profile');
        Route::get('/sign-up',[App\Http\Controllers\UserController::class, 'sign_up'])->name('sign-up');

        

        //auth
        Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');

  
   

  
;

});
   

    Route::get('/logout', '\App\Http\Controllers\Auth\LoginController@logout');
    Auth::routes();
});