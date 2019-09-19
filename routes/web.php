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
            Route::post('/delete/avatar', 'ImageController@deleteAvatar')->name('delete.avatar');
        });
    });
    
    // Manage film data
    Route::group(['prefix' => '/manage',  'middleware' => 'auth'], function () {
        Route::post('/add/comment', 'CommentsController@addComment')->name('add.comment');
        // wishlist
        Route::post('/add/film/wishlist', 'WishlistController@addFilm')->name('add.film.wishlist');
        Route::post('delete/film/wishlist', 'WishlistController@deleteFilm')->name('delete.film.wishlist');
        // history
        Route::post('/add/film/history', 'HistoryController@addFilm')->name('add.film.history');
        Route::post('delete/film/history', 'HistoryController@deleteFilm')->name('delete.film.history');
        // recommendations
        Route::post('/add/film/recommendation', 'RecommendationsController@addFilm')->name('add.film.recommendation');
        Route::post('delete/film/recommendation', 'RecommendationsController@deleteFilm')->name('delete.film.recommendation');
    });
    
    // Research
    Route::group(['prefix' => '/', 'middleware' => 'auth'], function () {
        Route::get('/{page?}', 'BrowseMoviesController@showMainPageWithTopFilms')->name('main');
        Route::get('/search/params', 'BrowseMoviesController@searchByParams')->name('search.params');
        Route::get('/search/title', 'BrowseMoviesController@searchByTitle')->name('search.title');
        Route::get('/watch/{imdbId}', 'BrowseMoviesController@watchMovie')->name('watch');
    });
    
    // Localization
    Route::get('/lang/{language}', 'LocaleController@changeLang')->name('change.language');
    
    // Oauth via 42, GitHub, etc
    Route::group(['prefix' => '/oauth', 'middleware' => 'guest'], function () {
        Route::get('/{provider}', 'Auth\Oauth\OauthController@redirectToProvider')->name('oauth');
        Route::get('/{provider}/callback', 'Auth\Oauth\OauthController@handleProviderCallback');
    });
    
