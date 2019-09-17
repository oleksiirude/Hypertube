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
    
        public function getTopRatedMovies($page = 0)
        {
            $movies = DB::select("SELECT films.*, titles.*, posters.*, GROUP_CONCAT(genre SEPARATOR ',') as genres
                                  FROM films, titles, posters, genres
                                  WHERE films.imdb_id = titles.imdb_id
                                  AND films.imdb_id = posters.imdb_id
                                  AND films.imdb_id = genres.imdb_id
                                  GROUP BY films.imdb_id
                                  ORDER BY films.rating*1 DESC LIMIT 12 OFFSET $page");
            
            foreach ($movies as $item) {
                $title = $this->title;
                $poster = $this->poster;
                
                $item->title = $item->$title;
                $item->poster = $item->$poster;
                $item->genres = explode(',', $item->genres);
                
                $this->unsetRedundant($item);
            }
            
            return $movies;
        }
        
        public function getMovieByTitle($search)
        {
            $result = DB::select("SELECT  films.*, titles.*, posters.*
                                  FROM films, titles, posters
                                  WHERE (films.imdb_id = titles.imdb_id AND films.imdb_id = posters.imdb_id)
                                  AND (titles.en_title LIKE '%$search%' OR titles.uk_title LIKE '%$search%' OR titles.ru_title LIKE '%$search%')
                                  ORDER BY films.rating*1 DESC LIMIT 4");
            
            foreach ($result as $item) {
                $title = $this->title;
                $poster = $this->poster;
    
                $item->title = $item->$title;
                $item->poster = $item->$poster;
                $item->link = asset('watch/' . $item->imdb_id);
    
                $this->unsetRedundant($item);
            }
            
            return count($result) ? $this->jsonResponseWithSuccess($result) : $this->jsonResponseWithError();
        }
        
        public function getMoviesByParams($params)
        {
            $params->page = $params->page * 12;
            
            if ($params->sort === 'rating')
                $params->sort = 'films.rating*1';
            else if ($params->sort === 'title')
                $params->sort = $this->title;
            
            if ($params->genre === 'all') {
                $movies = DB::select("SELECT films.*, titles.*, posters.*, GROUP_CONCAT(genre SEPARATOR ',') as genres
                                    FROM films, titles, posters, genres
                                    WHERE films.prod_year BETWEEN $params->year_from AND $params->year_to
                                    AND films.rating >= $params->min_rating
                                    AND films.imdb_id = titles.imdb_id
                                    AND films.imdb_id = posters.imdb_id
                                    AND films.imdb_id = genres.imdb_id
                                    GROUP BY films.imdb_id
                                    ORDER BY $params->sort $params->order
                                    LIMIT 12 OFFSET $params->page");
                
                foreach ($movies as $movie) {
                    $title = $this->title;
                    $poster = $this->poster;
    
                    $movie->title = $movie->$title;
                    $movie->poster = $movie->$poster;
                    $movie->genres = explode(',', $movie->genres);
    
                    $this->unsetRedundant($movie);
                }
            }
            else {
                $movies = DB::select("SELECT films.*, titles.*, posters.*, genres.genre
                                    FROM films, titles, posters, genres
                                    WHERE genres.genre = $params->genre
                                    AND films.prod_year BETWEEN $params->year_from AND $params->year_to
                                    AND films.rating >= $params->min_rating
                                    AND films.imdb_id = titles.imdb_id
                                    AND films.imdb_id = posters.imdb_id
                                    AND films.imdb_id = genres.imdb_id
                                    ORDER BY $params->sort $params->order
                                    LIMIT 12 OFFSET $params->page");
    
                foreach ($movies as $movie) {
                    $result = DB::select("SELECT GROUP_CONCAT(genre SEPARATOR ',') as genres
                                FROM genres
                                WHERE genres.imdb_id = '$movie->imdb_id'
                                GROUP BY genres.imdb_id")[0];
    
                    $title = $this->title;
                    $poster = $this->poster;
    
                    $movie->title = $movie->$title;
                    $movie->poster = $movie->$poster;
                    $movie->genres = explode(',', $result->genres);
    
                    $this->unsetRedundant($movie);
                }
            }
            
            return count($movies) ? $this->jsonResponseWithSuccess($movies) : $this->jsonResponseWithError();
        }
        
        protected function unsetRedundant($item)
        {
            unset($item->en_title);
            unset($item->uk_title);
            unset($item->ru_title);
            unset($item->en_poster);
            unset($item->uk_poster);
            unset($item->ru_poster);
        }
    }
