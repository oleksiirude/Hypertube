<?php

    namespace App\Http\Controllers;
    
    use App;
    use Exception;

    class TorrentsController extends Controller
    {
        public static function getPopularMoviesSortedByRating($client, $page = 1)
        {
            try {
                $response = $client->request('GET',
                    'https://yts.am/api/v2/list_movies.json', [
                        'query' => [
                            'sort_by' => 'download_count',
                            'page' => $page,
                            'limit' => 12
                        ]
                    ]);
        
                $results = json_decode($response->getBody());

                return $results->data->movies;
            } catch (Exception $e) {
                return false;
            }
        }
        
        public static function getMoviesByParams($client, $params)
        {
            try {
                $response = $client->request('GET',
                    'https://yts.am/api/v2/list_movies.json', [
                        'query' => [
                            'genre' => $params['genre'],
                            'minimum_rating' => $params['min_rating'],
                            'sort_by' => $params['sort'],
                            'order_by' => $params['order'],
                            'limit' => 12
                        ]
                    ]);
                
                $results = json_decode($response->getBody());
                
                    $i = 0;
                    foreach ($results->data->movies as $item) {
                        if ($params['year_from'] > $item->year || $params['year_to'] < $item->year)
                            unset($results->data->movies[$i]);
                        $i++;
                    }
                    
                return $results->data->movies;
            } catch (Exception $e) {
                return false;
            }
        }
        
        public static function getMovie($client, $param)
        {
            try {
                $response = $client->request('GET',
                    'https://yts.am/api/v2/list_movies.json', [
                        'query' => [
                            'query_term' => $param,
                            'sort_by' => 'download_count'
                        ]
                    ]);
        
                $results = json_decode($response->getBody());
        
                return $results->data->movies;
            } catch (Exception $e) {
                return false;
            }
        }
    }
