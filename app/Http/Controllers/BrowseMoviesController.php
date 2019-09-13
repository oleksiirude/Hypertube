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
            return view('main', ['content' => SearchController::getTwelveTopRatedMovies(LocaleController::getLang())]);
        }
        
        protected function searchByTitle(Request $request)
        {
            $title = $request->get('title');
            
            if (!preg_match('/^[a-zа-яёїі :!?,.]{2,100}$/iu', $title))
                return $this->jsonResponseWithError();
            
            $data = SearchController::getMovieByTitle($title, session()->get('locale'));
    
            return view('main', ['content' => $data]);
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
