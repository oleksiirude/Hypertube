<?php

    namespace App\Http\Controllers;

    use App;
    use Validator;
    use Illuminate\Http\Request;

    class BrowseMoviesController extends Controller
    {
        protected function showMainPageWithTopFilms(Request $request, $page = 0)
        {
            if ($page && !$request->headers->has('XMLHttpRequest'))
                abort(404);
                
            return $page
                ? $this->jsonResponseWithSuccess((new SearchController())->getTopRatedMovies($page * 12))
                : view('main', ['content' => (new SearchController())->getTopRatedMovies(0)]);
        }
        
        protected function searchByTitle(Request $request) {

            if (!preg_match('/^[0-9a-zа-яёїі :!?,.]{2,100}$/iu', $request->get('title')))

                return $this->jsonResponseWithError();
    
            $searcher = new SearchController();
            return $searcher->getMovieByTitle($request->get('title'));
        }
    
        protected function searchByParams(Request $request)
        {
            if (!$request->headers->has('XMLHttpRequest'))
                abort(404);
            
            $validation = Validator::make($request->all(), $this->rules());
            
            if ($validation->fails())
                return $this->jsonResponseWithError();
            
            return (new SearchController())->getMoviesByParams((object)$request->all());
        }

        protected function watchMovie($imdbId)
        {
            $movie = (new APIController())->getMovieByImdbId($imdbId);

            if (!$movie)
                return abort(404);

            return view('watch', [
                'content' => $movie,
                'comments' => CommentsController::getComments($imdbId),
                'wishlist' => WishlistController::checkIfInWishlist($imdbId),
                'recommendations' => RecommendationsController::checkIfInRecommendations($imdbId)
            ]);
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
                ],
                'page' => [
                    'required',
                    'regex:/^[0-9]{1,}$/'
                ]
            ];
        }
    }
