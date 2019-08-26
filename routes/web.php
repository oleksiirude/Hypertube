<?php
    
    Route::get('/welcome', function () {return view('welcome');})
        ->name('welcome')
        ->middleware('guest');
    
    Auth::routes();
    
    Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
        Route::get('/', 'MainPageController@index')->name('main');
        Route::get('/search', 'MainPageController@searchByTitle')->name('search.title');
    });
    
    Route::get('/imdb', 'MainPageController@imdb')->name('imdb');
    Route::get('/tmdb', 'MainPageController@tmdb')->name('tmdb');
    
    
    // Profile manipulations
    Route::group(['prefix' => '/profile', 'middleware' => 'auth'], function () {
        Route::get('/', 'ProfileController@showAuthProfile')->name('show.auth');
        Route::get('/{login}', 'ProfileController@showUserProfile')->name('show.user');
        
        Route::group(['prefix' => '/change'], function () {
            Route::post('/login', 'ProfileController@changeLogin')->name('change.login');
            Route::post('/info', 'ProfileController@changeInfo')->name('change.info');
            Route::post('/first/name', 'ProfileController@changeFirstName')->name('change.firstName');
            Route::post('/last/name', 'ProfileController@changeLastName')->name('change.lastName');
            Route::post('/email', 'ProfileController@changeEmail')->name('change.email');
            Route::post('/password', 'ProfileController@changePassword')->name('change.password');
            Route::post('/avatar', 'ImageController@changeAvatar')->name('change.avatar');
        });
    
        Route::group(['prefix' => '/delete'], function () {
            Route::post('/avatar', 'ImageController@deleteAvatar')->name('delete.avatar');
        });
    });
    
    // Auth via 42, GitHub, etc
    Route::group(['prefix' => '/oauth', 'middleware' => 'guest'], function () {
        Route::get('/{provider}', 'Auth\Oauth\OauthController@redirectToProvider')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\Oauth\OauthController@handleProviderCallback');
    });
    
    // Localization
    Route::get('/lang/{language}', 'LocaleController@setLanguage')->name('set.language');
    
