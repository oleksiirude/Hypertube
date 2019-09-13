<?php

    namespace App\Http\Controllers;
    
    use Illuminate\Support\Facades\DB;

    class SearchController extends Controller
    {
        protected $title;
        protected $poster;
        
        public function __construct($lang)
        {
            $this->title = $lang . '_title';
            $this->poster = $lang . '_poster';
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
                                  ORDER BY rating*1 DESC LIMIT 12");
            
            foreach ($movies as $item)
                $item->genres = explode(',', $item->genres);
         
            return $movies;
        }
        
        public function getMovieByTitle($search)
        {
            $result = DB::select("SELECT films.*, $this->title as title, $this->poster
                                  FROM titles, films, posters
                                  WHERE titles.$this->title LIKE '%$search%'
                                  AND titles.imdb_id = films.imdb_id
                                  AND titles.imdb_id = posters.imdb_id
                                  ORDER BY rating*1 DESC LIMIT 4");
            
            foreach ($result as $item)
                $item->link = asset('watch/' . $item->imdb_id);
            
            return count($result) ? $this->jsonResponseWithSuccess($result) : $this->jsonResponseWithError();
        }
        
        public function getMoviesByParams($params)
        {
            if ($params->sort === 'rating')
                $params->sort = 'rating*1';
            
            if ($params->genre === 'all') {
                $result = DB::select("SELECT films.*, $this->title as title, $this->poster as poster, GROUP_CONCAT(genre SEPARATOR ',') as genres
                                    FROM films, titles, posters, genres
                                    WHERE films.prod_year BETWEEN $params->year_from AND $params->year_to
                                    AND films.rating >= $params->min_rating
                                    AND films.imdb_id = titles.imdb_id
                                    AND films.imdb_id = posters.imdb_id
                                    AND films.imdb_id = genres.imdb_id
                                    GROUP BY films.imdb_id
                                    ORDER BY $params->sort $params->order
                                    LIMIT 12");
            }
            else {
                $result = DB::select("SELECT films.*, $this->title as title, $this->poster as poster, GROUP_CONCAT(genre SEPARATOR ',') as genres
                                    FROM films, titles, posters, genres
                                    WHERE films.prod_year BETWEEN $params->year_from AND $params->year_to
                                    AND films.rating >= $params->min_rating
                                    AND films.imdb_id = titles.imdb_id
                                    AND films.imdb_id = posters.imdb_id
                                    AND films.imdb_id = genres.imdb_id
                                    AND genres.genre = $params->genre
                                    GROUP BY films.imdb_id
                                    ORDER BY $params->sort $params->order
                                    LIMIT 12");
            }
    
            return count($result) ? $this->jsonResponseWithSuccess($result) : $this->jsonResponseWithError();
        }
    }
