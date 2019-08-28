<?php

    namespace App\Http\Controllers;
    
    use App;
    use Exception;
    use stdClass;

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
                            'limit' => 9
                        ]
                    ]);
        
                $results = json_decode($response->getBody());
                
                foreach ($results->data->movies as $result) {
                    $new = new stdClass();
                    $new->year = $result->year;
                    $new->title = $result->title;
                    $new->imdb_code = $result->imdb_code;
                    $new->slug = $result->slug;
                    $new->large_cover_image = $result->large_cover_image;
                    $new->rating = $result->rating;
                    $new->genres = $result->genres;
                    $filteredData[] = $new;
                }
                
                return $filteredData;
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
