<?php

    namespace App\Http\Controllers;

    use App;
    use Validator;
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
        
        protected function showMainPageWithTopFilms()
        {
            return view('main', ['content' => $this->searcher->getTwelveTopRatedMovies()]);
        }
        
        protected function searchByTitle(Request $request)
        {
            if (!preg_match('/^[a-zа-яёїі :!?,.]{4,100}$/iu', $request->get('title')))
                return $this->jsonResponseWithError();
            
            return $this->searcher->getMovieByTitle($request->get('title'));
        }
    
    
        protected function searchByParams(Request $request)
        {
            $validation = Validator::make($request->all(), $this->rules());
    
            if ($validation->fails())
                return $this->jsonResponseWithError();
            
            return $this->searcher->getMoviesByParams((object)$request->all());
        }
        
        protected function watchMovie($imdbId)
        {
            $data = TorrentsController::getMovie($this->client, $imdbId)[0];
            
            $data = TMDBController::getTranslatedAndAdditionalDataForItem($this->client, $data, App::getLocale());
            
            return view('watch', ['content' => $data]);
        }
    
        protected function rules()
        {
            return [
                'genre' => [
                    'required',
                    'regex:/^all|28|12|16|35|80|99|18|10751|14|36|27|10402|9648|878|10770|53|10752|37$/'
                ],
                'year_from' => 'required|regex:/^[0-9]{4}$/',
                'year_to' => 'required|regex:/^[0-9]{4}$/',
                'min_rating' => 'required|regex:/^[0-9]{1,2}$/',
                'sort' => [
                    'required',
                    'regex:/^prod_year|rating|title$/'
                ],
                'order' => [
                    'required',
                    'regex:/^ASC|DESC$/'
                ]
            ];
        }
    }
