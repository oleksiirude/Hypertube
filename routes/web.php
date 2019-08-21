<?php
    
    Route::get('/', function () {return view('welcome');})
        ->name('welcome')
        ->middleware('guest');
    
    Auth::routes();
    
    Route::get('/main', 'MainPageController@index')->name('main');
    
    // Auth via 42, GitHub, etc
    Route::group(['prefix' => '/auth'], function () {
        Route::get('/42', 'Auth\AuthServices\FortyTwoAuthController@redirectToFortyTwo')->name('login_42');
        Route::get('/42/callback', 'Auth\AuthServices\FortyTwoAuthController@handleFortyTwoCallback');
        
        Route::get('/github', 'Auth\AuthServices\GitHubAuthController@redirectToGitHub')->name('login_github');
        Route::get('/github/callback', 'Auth\AuthServices\GitHubAuthController@handleGitHubCallback');
    });
    
    // Localization
    Route::get('/lang/{language}', 'LocaleController@setLanguage')->name('set.language');
    
