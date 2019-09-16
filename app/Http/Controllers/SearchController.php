<?php

    namespace App\Http\Controllers;
    
    use Illuminate\Support\Facades\DB;

    class SearchController extends Controller
    {
        protected $title;
        protected $poster;
        
        public function __construct()
        {
            $this->title = LocaleController::getLang() . '_title';
            $this->poster = LocaleController::getLang() . '_poster';
        }
    
        public function getTwelveTopRatedMovies()
        {
            $movies = DB::select("SELECT films.*, $this->title as title, $this->poster as poster, GROUP_CONCAT(genre SEPARATOR ',') as genres
                                  FROM films, titles, posters, genres
                                  WHERE films.prod_year = 2019
                                  AND films.imdb_id = titles.imdb_id
                                  AND films.imdb_id = posters.imdb_id
                                  AND films.imdb_id = genres.imdb_id
                                  GROUP BY films.imdb_id
                                  ORDER BY films.rating*1 DESC LIMIT 12");
            
            foreach ($movies as $item)
                $item->genres = explode(',', $item->genres);
         
            return $movies;
        }
        
        public function getMovieByTitle($search)
        {
            $result = DB::select("SELECT  films.*, $this->title as title, $this->poster as poster
                                  FROM films, titles, posters
                                  WHERE (films.imdb_id = titles.imdb_id AND films.imdb_id = posters.imdb_id)
                                  AND (titles.en_title LIKE '%$search%' OR titles.uk_title LIKE '%$search%' OR titles.ru_title LIKE '%$search%')
                                  ORDER BY films.rating*1 DESC LIMIT 4");
            
            foreach ($result as $item)
                $item->link = asset('watch/' . $item->imdb_id);
            
            return count($result) ? $this->jsonResponseWithSuccess($result) : $this->jsonResponseWithError();
        }
        
        public function getMoviesByParams($params)
        {
            if ($params->sort === 'rating')
                $params->sort = 'films.rating*1';

            if ($params->genre === 'all') {
                $movies = DB::select("SELECT films.*, $this->title as title, $this->poster as poster, GROUP_CONCAT(genre SEPARATOR ',') as genres
                                    FROM films, titles, posters, genres
                                    WHERE films.prod_year BETWEEN '$params->year_from' AND '$params->year_to'
                                    AND films.rating >= '$params->min_rating'
                                    AND films.imdb_id = titles.imdb_id
                                    AND films.imdb_id = posters.imdb_id
                                    AND films.imdb_id = genres.imdb_id
                                    GROUP BY films.imdb_id
                                    ORDER BY $params->sort $params->order
                                    LIMIT 12");
                
                foreach ($movies as $movie) {
                    $movie->genres = explode(',', $movie->genres);
                }
            }
            else {
                $movies = DB::select("SELECT films.*, $this->title as title, $this->poster as poster, GROUP_CONCAT(genre SEPARATOR ',') as genres
                                    FROM films, titles, posters, genres
                                    WHERE films.prod_year BETWEEN '$params->year_from' AND '$params->year_to'
                                    AND films.rating >= '$params->min_rating'
                                    AND films.imdb_id = titles.imdb_id
                                    AND films.imdb_id = posters.imdb_id
                                    AND films.imdb_id = genres.imdb_id
                                    AND genres.genre = '$params->genre'
                                    GROUP BY films.imdb_id
                                    ORDER BY $params->sort $params->order
                                    LIMIT 12");
    
                foreach ($movies as $movie) {
                    $result = DB::select("SELECT GROUP_CONCAT(genre SEPARATOR ',') as genres
                                FROM genres
                                WHERE genres.imdb_id = '$movie->imdb_id'
                                GROUP BY genres.imdb_id")[0];
                    $movie->genres = explode(',', $result->genres);
                }
            }
            
            return count($movies) ? $this->jsonResponseWithSuccess($movies) : $this->jsonResponseWithError();
        }
    }
