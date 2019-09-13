<?php

    namespace App\Http\Controllers;

    use App;
    use Illuminate\Http\Request;
    
    class BrowseMoviesController extends Controller
    {
        protected $searcher;
        
        public function __construct()
        {
            $this->middleware(function ($request, $next) {
                $this->searcher = new SearchController(LocaleController::getLang());
                return $next($request);
            });
        }
        
        protected function showMainPageWithSuggestions()
        {
            $top = $this->searcher->getTwelveTopRatedMovies();
            
            return view('main', ['content' => $top]);
        }
        
        protected function searchByTitle(Request $request)
        {
            $title = $request->get('title');
            
            if (!preg_match('/^[a-zа-яёїі :!?,.]{4,100}$/iu', $title))
                return $this->jsonResponseWithError();
            
            return $this->searcher->getMovieByTitle($title);
        }
    
    
        protected function researchByParams(Request $request)
        {
            $params = $request->all();
          
            $data = TorrentsController::getMoviesByParams($this->client, $params);
    
            if (App::getLocale() !== 'en')
                $data = TMDBController::getTranslatedDataForItems($this->client, $data, App::getLocale());
            
            
            return view('main', ['content' => $data]);
            
        }
        
        protected function watchMovie($imdbId)
        {
            $data = TorrentsController::getMovie($this->client, $imdbId)[0];
            
            $data = TMDBController::getTranslatedAndAdditionalDataForItem($this->client, $data, App::getLocale());
            
            return view('watch', ['content' => $data]);
        }
    }
