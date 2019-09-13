<?php

    namespace App\Http\Controllers;
    
    use Illuminate\Support\Facades\DB;

    class SearchController extends Controller
    {
        static public function getTwelveTopRatedMovies($locale)
        {
            $title = $locale . '_title';
            $poster = $locale . '_poster';
            
            $movies = DB::select("SELECT films.*, $title as title, $poster as poster, GROUP_CONCAT(genre SEPARATOR ',') as genres
                                   FROM films, titles, posters, genres
                                   WHERE films.rating >= 7
                                   AND films.prod_year = 2019
                                   AND films.imdb_id = titles.imdb_id
                                   AND films.imdb_id = posters.imdb_id
                                   AND films.imdb_id = genres.imdb_id
                                   GROUP BY films.imdb_id
                                   ORDER BY rating*1 DESC LIMIT 12");
            
            foreach ($movies as $item)
                $item->genres = explode(',', $item->genres);
         
            return $movies;
        }
        
        static public function getMovieByTitle($search, $locale)
        {
            $title = $locale . '_title';
            $poster = $locale . '_poster';
            
            $movies = DB::select("SELECT $title as title
                                  FROM titles
                                  WHERE titles.en_title LIKE '%$search%'
                                  OR titles.uk_title LIKE '%$search%'
                                  OR titles.ru_title LIKE '%$search%'");
            dd($movies);
        }
    }
