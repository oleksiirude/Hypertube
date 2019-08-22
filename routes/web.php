<?php
    
    Route::get('/', function () {return view('welcome');})
        ->name('welcome')
        ->middleware('guest');
    
    Auth::routes();
    
    Route::get('/main', 'MainPageController@index')->name('main');
    
    // Profile manipulations
    Route::group(['prefix' => '/profile', 'middleware' => 'auth'], function () {
        Route::get('/show/auth', 'ProfileController@showAuthProfile')->name('profile.show.auth');
        Route::get('/show/user', 'ProfileController@showUserProfile')->name('profile.show.user');
        
        Route::post('/change/login', 'ProfileController@changeLogin')->name('profile.change.login');
        Route::post('/change/first-name', 'ProfileController@changeFirstName')->name('profile.change.first-name');
        Route::post('/change/last-name', 'ProfileController@changeLastName')->name('profile.change.last-name');
        Route::post('/change/email', 'ProfileController@changeEmail')->name('profile.change.email');
        Route::post('/change/password', 'ProfileController@changePassword')->name('profile.change.password');
        Route::post('/change/avatar', 'ImageController@changeAvatar')->name('profile.change.avatar');
    });
    
    // Auth via 42, Facebook, GitHub, etc
    Route::group(['prefix' => '/oauth', 'middleware' => 'guest'], function () {
        Route::get('/{provider}', 'Auth\Oauth\OauthController@redirectToProvider')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\Oauth\OauthController@handleProviderCallback');
    });
    
    // Localization
    Route::get('/lang/{language}', 'LocaleController@setLanguage')->name('set.language');
    
