<?php

    namespace App\Http\Controllers;
    
    use App;
    use Exception;

    class TMDBController extends Controller
    {
        public static function getTranslatedDataForItems($client, $data, $lang)
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
                    
                    if (preg_match('/^.*[а-яёїі]{1,}.*$/iu', $item->movie_results[0]->title))
                        $movie->title = $item->movie_results[0]->title;
                    $movie->large_cover_image = BASE_URL . BIG . $item->movie_results[0]->poster_path;
                } catch (Exception $e) {
                    return false;
                }
            }
      
            return $data;
        }
    
        public static function getTranslatedAndAdditionalDataForItem($client, $item, $lang)
        {
            try {
                $response = $client->request('GET',
                    'https://api.themoviedb.org/3/find/' . $item->imdb_code, [
                        'query' => [
                            'external_source' => 'imdb_id',
                            'language' => $lang,
                            'api_key' => config('keys.tmdb')
                        ]
                    ]);
                $data = json_decode($response->getBody());
               
                $response = $client->request('GET',
                    'https://api.themoviedb.org/3/movie/' . $data->movie_results[0]->id, [
                        'query' => [
                            'external_source' => 'imdb_id',
                            'language' => $lang,
                            'api_key' => config('keys.tmdb'),
                            'append_to_response' => 'credits'
                        ]
                    ]);
                $data = json_decode($response->getBody());
                
                if (preg_match('/^.*[а-яёїі]{1,}.*$/iu', $data->title))
                    $item->title = $data->title;
                $item->large_cover_image = BASE_URL . BIG . $data->poster_path;
                $item->summary = $data->overview;
                $item->actors = $data->credits->cast;
                $item->studio = $data->production_companies[0]->name;
           
                return $item;
            } catch (Exception $e) {
                return false;
            }
        }
    }
