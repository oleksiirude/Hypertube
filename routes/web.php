<?php
    
    Route::get('/', function () {
        return view('welcome');
    });
    
    Auth::routes();
    
    Route::get('/home', 'HomeController@index')->name('home');
    
    Route::post('/test', 'HomeController@test')->name('test');
    
    Route::post('/axios', 'HomeController@axios')->name('axios');
