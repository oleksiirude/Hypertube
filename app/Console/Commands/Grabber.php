<?php

    namespace App\Console\Commands;

    use PDO;
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
        protected $description = 'Grab all films from yts.lt';
    
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
            $start = time();
            $filmCounter = 0;
            echo 'grabber started...' . PHP_EOL;
            
            $client = new Client();
    
            $response = $client->request('GET', 'https://yts.am/api/v2/list_movies.json');
            $results = json_decode($response->getBody());

            $pageCount = (int)round($results->data->movie_count / 20 + 1, 1 ,PHP_ROUND_HALF_UP);
            
            //$i = 1;
            $i = 659;
            $sleepCounter = 0;
            while ($i <= $pageCount) {
                $response = $client->request('GET',
                    'https://yts.am/api/v2/list_movies.json', [
                        'query' => [
                            'page' => (string)$i,
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

                        // GET GENRES
                        if (isset($data->movie_results[0])) {
                            foreach ($data->movie_results[0]->genre_ids as $genre_id) {
                                file_put_contents(public_path() . '/genres.txt',
                                    $movie->imdb_code . ';' . $genre_id . PHP_EOL, FILE_APPEND);
                            }
                        } else {
                            echo 'no data in TMDB with ' . $movie->imdb_code .  ' continue...' . PHP_EOL;
                            continue;
                        }
    
                        // GET FILMS
                        file_put_contents(public_path() . '/films.txt',
                            $movie->imdb_code . ';' . $movie->year . ';' . $movie->rating . PHP_EOL, FILE_APPEND);

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

                        file_put_contents(public_path() . '/titles.txt',
                            $movie->imdb_code . ';' . $movie->title . ';' . $uk->title .  ';' . $ru->title . PHP_EOL,
                            FILE_APPEND);

                        // GET LOCALIZED POSTERS
                        file_put_contents(public_path() . '/posters.txt',
                            $movie->imdb_code . ';' . $movie->large_cover_image . ';' . BASE_URL . BIG . $uk->poster_path . ';' . BASE_URL . BIG . $ru->poster_path . PHP_EOL,
                            FILE_APPEND);
                        
                        $filmCounter++;
                        echo $filmCounter . ' films have written to file' . PHP_EOL;
                        
                        if ($sleepCounter === 1) {
                            sleep(1);
                            $sleepCounter = 0;
                        }
                        else
                            $sleepCounter++;
                    }
                }
                $i++;
            }
            $end = time();
            $result = $end - $start;
    
            echo 'time: ' . round($result / 60, 2) . ' minutes' .PHP_EOL;
            echo 'data grabbed' . " ($filmCounter films)" . ' from yts.lt api and filled into file' . PHP_EOL;
            return $this->putDataIntoDB();
        }
        
        private function putDataIntoDB()
        {
            $con = new PDO("mysql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DATABASE'),
                            env('DB_USERNAME'),
                            env('DB_PASSWORD'), [
                                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                                PDO::MYSQL_ATTR_LOCAL_INFILE => true
                           ]);
            
            $con->query("LOAD DATA LOCAL INFILE \"" . public_path() . '/films.txt' . "\" INTO TABLE films FIELDS TERMINATED BY \";\" LINES TERMINATED BY \"\\n\"");
            $con->query("LOAD DATA LOCAL INFILE \"" . public_path() . '/titles.txt' . "\" INTO TABLE titles FIELDS TERMINATED BY \";\" LINES TERMINATED BY \"\\n\"");
            $con->query("LOAD DATA LOCAL INFILE \"" . public_path() . '/posters.txt' . "\" INTO TABLE posters FIELDS TERMINATED BY \";\" LINES TERMINATED BY \"\\n\"");
            $con->query("LOAD DATA LOCAL INFILE \"" . public_path() . '/genres.txt' . "\" INTO TABLE genres FIELDS TERMINATED BY \";\" LINES TERMINATED BY \"\\n\"");
            
            echo 'data inserted from file to db' . PHP_EOL;
            echo 'done' . PHP_EOL;
        }
    }
