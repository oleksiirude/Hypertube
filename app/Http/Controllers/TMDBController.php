<?php

    namespace App\Http\Controllers;
    
    use App;
    use Exception;

    class TMDBController extends Controller
    {
        public static function getTranslatedTitles($client, $data, $lang)
        {
            foreach ($data as $movie) {
                try {
                    $response = $client->request('GET',
                        'https://api.themoviedb.org/3/find/' . $movie->imdb_code, [
                            'query' => [
                                'external_source' => 'imdb_id',
                                'language' => $lang,
                                'api_key' => config('keys.tmdb')
                            ]
                        ]);
            
                    $item = json_decode($response->getBody());
    
                    $movie->title = $item->movie_results[0]->title;
                    $movie->large_cover_image = BASE_URL . BIG . $item->movie_results[0]->poster_path;
                } catch (Exception $e) {
                    return false;
                }
            }
            
            return $data;
        }
    }
