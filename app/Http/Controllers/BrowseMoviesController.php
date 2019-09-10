<?php

    namespace App\Http\Controllers;

    use App;
    use GuzzleHttp\Client;
    use Illuminate\Http\Request;
    
    class BrowseMoviesController extends Controller
    {
        protected $client;
        
        public function __construct()
        {
            $this->client = new Client();
        }
        
        protected function showMainPageWithSuggestions()
        {
            $data = TorrentsController::getPopularMoviesSortedByRating($this->client);
            
            if (App::getLocale() !== 'en')
                $data = TMDBController::getTranslatedDataForItems($this->client, $data, App::getLocale());
            
            return view('main', ['content' => $data]);
            
//            return view('main');
        }
        
        protected function searchByTitle(Request $request)
        {
            $title = $request->get('title');
            $data = TorrentsController::getMovie($this->client, $title);
            
            if (!$data)
                $data = TorrentsController::getPopularMoviesSortedByRating($this->client);
            
            if (App::getLocale() !== 'en')
                $data = TMDBController::getTranslatedDataForItems($this->client, $data, App::getLocale());
    
            return view('main', ['content' => $data]);
            
//            return $this->jsonResponseWithSuccess($data);
        }
    
    
        protected function researchByParams(Request $request)
        {
            $params = $request->all();
          
            $data = TorrentsController::getMoviesByParams($this->client, $params);
    
            if (App::getLocale() !== 'en')
                $data = TMDBController::getTranslatedDataForItems($this->client, $data, App::getLocale());
            
            
            return view('main', ['content' => $data]);
    
//            return $this->jsonResponseWithSuccess($data);
        }
        
        protected function watchMovie($imdbId)
        {
            $data = TorrentsController::getMovie($this->client, $imdbId)[0];
            
            $data = TMDBController::getTranslatedAndAdditionalDataForItem($this->client, $data, App::getLocale());
            
            //dd($data);
            return view('watch', ['content' => $data]);
        }
    }
