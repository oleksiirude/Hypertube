<?php
    
    Route::get('/welcome', function () {return view('welcome');})
        ->name('welcome')
        ->middleware('guest');
    
    Auth::routes();
    
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
    
        Route::group(['prefix' => '/delete',  'middleware' => 'auth'], function () {
            Route::post('/avatar', 'ImageController@deleteAvatar')->name('delete.avatar');
        });
    });
    
    // Research
    Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
        Route::get('/{page?}', 'BrowseMoviesController@showMainPageWithTopFilms')->name('main');
        Route::get('/search/params', 'BrowseMoviesController@searchByParams')->name('search.params');
        Route::get('/search/title', 'BrowseMoviesController@searchByTitle')->name('search.title');
        Route::get('/watch/{imdbId}', 'BrowseMoviesController@watchMovie')->name('watch');
    });
    
    // Localization
    Route::get('/lang/{language}', 'LocaleController@changeLang')->name('change.language')->middleware('auth');
    
    // Oauth via 42, GitHub, etc
    Route::group(['prefix' => '/oauth', 'middleware' => 'guest'], function () {
        Route::get('/{provider}', 'Auth\Oauth\OauthController@redirectToProvider')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\Oauth\OauthController@handleProviderCallback');
    });
    
