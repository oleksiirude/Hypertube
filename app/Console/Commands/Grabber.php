<?php

    namespace App\Console\Commands;
    
    use GuzzleHttp\Client;
    use Illuminate\Console\Command;
    
    class Grabber extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'grabber:go';
    
        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Grab all films data from yts.lt';
    
        /**
         * Create a new command instance.
         *
         * @return void
         */
        public function __construct()
        {
            parent::__construct();
        }
    
        /**
         * Execute the console command.
         *
         * @return mixed
         */
        public function handle()
        {
            echo 'grabbing data: launched' . PHP_EOL;
            $client = new Client();
    
            $response = $client->request('GET', 'https://yts.am/api/v2/list_movies.json');
            $results = json_decode($response->getBody());

            $pageCount = (int)round($results->data->movie_count / 20 + 1, 1 ,PHP_ROUND_HALF_UP);
            
            $i = 1;
            echo 'page ' . $i . ': started' . PHP_EOL;
            $start = time();
            $filmCounter = 0;
//            $sleepCounter = 0;
            while ($i <= $pageCount) {
                $response = $client->request('GET',
                    'https://yts.am/api/v2/list_movies.json', [
                        'query' => [
                            'limit' => 50,
                            'page' => $i,
                        ]
                    ]);
                $results = json_decode($response->getBody());

                if (isset($results->data->movies)) {
                    foreach ($results->data->movies as $movie) {
                        $response = $client->request('GET',
                            'https://api.themoviedb.org/3/find/' . $movie->imdb_code, [
                                'query' => [
                                    'external_source' => 'imdb_id',
                                    'api_key' => config('keys.tmdb')
                                ]
                            ]);
                        $data = json_decode($response->getBody());
    
                        // GET FILMS (year, rating)
                        $response = $client->request('GET',
                            'https://yts.am/api/v2/list_movies.json', [
                                'query' => [
                                    'query_term' => $movie->imdb_code,
                                ]
                            ]);
                        $result = json_decode($response->getBody());
                        
                        if (!isset($result->data->movies[0]->rating)) {
                            echo 'no rating data with ' . $movie->imdb_code .  ', continue...' . PHP_EOL;
                            continue;
                        }
                        
                        // GET GENRES
                        if (isset($data->movie_results[0])) {
                            foreach ($data->movie_results[0]->genre_ids as $genre_id) {
                                file_put_contents(base_path() . '/storage/app/public/grabber/genres.txt',
                                    $movie->imdb_code . ';' . $genre_id . PHP_EOL, FILE_APPEND);
                            }
                        } else {
                            echo 'no data on TMDB with ' . $movie->imdb_code .  ', continue...' . PHP_EOL;
                            continue;
                        }
    
                        file_put_contents(base_path() . '/storage/app/public/grabber/films.txt',
                            $movie->imdb_code . ';' . $movie->year . ';' . $result->data->movies[0]->rating . PHP_EOL, FILE_APPEND);
                        
                        // GET LOCALIZED TITLES
                        $tmdb_id = $data->movie_results[0]->id;

                        $response = $client->request('GET',
                            'https://api.themoviedb.org/3/movie/' . $tmdb_id, [
                                'query' => [
                                    'external_source' => 'imdb_id',
                                    'language' => 'uk',
                                    'api_key' => config('keys.tmdb'),
                                ]
                            ]);
                        $uk = json_decode($response->getBody());

                        $response = $client->request('GET',
                            'https://api.themoviedb.org/3/movie/' . $tmdb_id, [
                                'query' => [
                                    'external_source' => 'imdb_id',
                                    'language' => 'ru',
                                    'api_key' => config('keys.tmdb'),
                                ]
                            ]);

                        $ru = json_decode($response->getBody());

                        file_put_contents(base_path() . '/storage/app/public/grabber/titles.txt',
                            $movie->imdb_code . ';' . $movie->title . ';' . $uk->title .  ';' . $ru->title . PHP_EOL,
                            FILE_APPEND);

                        // GET LOCALIZED POSTERS
                        file_put_contents(base_path() . '/storage/app/public/grabber/posters.txt',
                            $movie->imdb_code . ';' . $movie->large_cover_image . ';' . BASE_URL . BIG . $uk->poster_path . ';' . BASE_URL . BIG . $ru->poster_path . PHP_EOL,
                            FILE_APPEND);
                        
                        $filmCounter++;
                        echo $filmCounter . ' films have written to files, imdb_id->' . $movie->imdb_code . ', rating-> ' . $result->data->movies[0]->rating .PHP_EOL;
                        
//                        if ($sleepCounter === 1) {
//                            sleep(1);
//                            $sleepCounter = 0;
//                        }
//                        else
//                            $sleepCounter++;
                    }
                }
                echo 'page ' . $i . ': done' . PHP_EOL;
                $i++;
            }
            $end = time();
            $result = $end - $start;
    
            echo 'consumed time: ' . round($result / 60, 2) . ' minutes' . PHP_EOL;
            echo 'data grabbed' . " ($filmCounter films)" . ' from yts.lt api and filled into files' . PHP_EOL;
        }
    }
