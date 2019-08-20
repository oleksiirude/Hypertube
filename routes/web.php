<?php
    
    Route::get('/', function () {return view('welcome');})
        ->name('welcome')
        ->middleware('guest');
    
    Auth::routes();
    
    Route::get('/main', 'MainPageController@index')->name('main');
    
    // Localization
    Route::get('/lang/{language}', 'LocaleController@setLanguage')->name('set.language');
    
