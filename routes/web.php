<?php
    
    Route::get('/', function () {return view('welcome');})
        ->name('welcome')
        ->middleware('guest');
    
    Auth::routes();
    
    Route::get('/main', 'MainPageController@index')->name('main');
    
    // Auth via 42, Facebook, GitHub, etc
    Route::group(['prefix' => '/oauth'], function () {
        Route::get('/{provider}', 'Auth\Oauth\OauthController@redirectToProvider')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\Oauth\OauthController@handleProviderCallback');
    });
    
    // Localization
    Route::get('/lang/{language}', 'LocaleController@setLanguage')->name('set.language');
    
