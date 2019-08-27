<?php

    namespace App\Http\Controllers;
    
    use App;
    use Exception;
    use GuzzleHttp\Client;

    class TMDBController extends Controller
    {
        private $key;
        private $client;
        
        public function __construct()
        {
            $this->key = config('keys.tmdb');
            $this->client = new Client();
        }
        
        public function getByTitle($title, $page = 1)
        {
            try {
                $response = $this->client->request('GET',
                'https://api.themoviedb.org/3/search/movie', [
                    'query' => [
                        'api_key' => $this->key,
                        'language' => App::getLocale(),
                        'query' => urlencode($title),
                        'page' => $page,
                        'include_adult' => 'false'
                    ]
                ]);
                
                $results = json_decode($response->getBody());
                
                if (!$results->total_results)
                    return false;
                
                return $results;
            } catch (Exception $e) {
                return false;
            }
        }
        
        private function getApiConfiguration()
        {
            $response = $this->client->request('GET',
                'https://api.themoviedb.org/3/discover/movie?with_genres=18&primary_release_year=2019'
//                , [
//                    'query' => [
//                        'api_key' => $this->key,
//                    ]
//                ]
            );
    
            return json_decode($response->getBody());
        }
    }
