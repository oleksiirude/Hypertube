<?php

    namespace App\Console\Commands;
    
    use Exception;
    use DB;
    use GuzzleHttp\Client;
    use Illuminate\Console\Command;

    class UpdateDataBase extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'database:update';
    
        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Update Hypertube DB according to yts database';
    
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
            echo 'update: start' . PHP_EOL;
            $client = new Client();
            $updates = [];
        
            try {
                $response = $client->request('GET',
                    'https://yts.am/api/v2/list_movies.json', [
                        'query' => [
                            'limit' => '50',
                            'sort_by' => 'date_added',
                            'order_by' => 'desc'
                        ]
                    ]);
            
                $movies = (json_decode($response->getBody()))->data->movies;
            } catch (Exception $e) {
                return $e->getMessage() . PHP_EOL;
            }
            
            if ($movies) {
                foreach ($movies as $movie) {
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
        
                    if (!isset($result->data->movies[0]->rating))
                        continue;
        
                    $updates[$movie->imdb_code] = [];
                    $updates[$movie->imdb_code]['imdb_id'] = $movie->imdb_code;
    
                    
                    // GET GENRES
                    $updates[$movie->imdb_code]['genres'] = [];
                    if (isset($data->movie_results[0])) {
                        foreach ($data->movie_results[0]->genre_ids as $genre_id) {
                            $updates[$movie->imdb_code]['genres'][] = $genre_id;
                        }
                    } else {
                        unset($updates[$movie->imdb_code]);
                        continue;
                    }
    
                    $updates[$movie->imdb_code]['prod_year'] = $movie->year;
                    $updates[$movie->imdb_code]['rating'] = $movie->rating;
        
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
    
                    // GET LOCALIZED TITLES
                    $updates[$movie->imdb_code]['titles'] = [];
                    $updates[$movie->imdb_code]['titles']['en_title'] = $movie->title;
                    $updates[$movie->imdb_code]['titles']['uk_title'] = $uk->title;
                    $updates[$movie->imdb_code]['titles']['ru_title'] = $ru->title;
    
                    // GET LOCALIZED POSTERS
                    $updates[$movie->imdb_code]['posters'] = [];
                    $updates[$movie->imdb_code]['posters']['en_poster'] = $movie->large_cover_image;
                    $updates[$movie->imdb_code]['posters']['uk_poster'] = BASE_URL . BIG . $uk->poster_path;
                    $updates[$movie->imdb_code]['posters']['ru_poster'] = BASE_URL . BIG . $ru->poster_path;
                    sleep(1);
                }
                echo count($updates) . ' new films grabbed, pushing into db...' . PHP_EOL;
                $this->pushIntoDB($updates);
                echo 'done' . PHP_EOL;
            }
        }
        
        private function pushIntoDB($updates)
        {
            $i = 0;
            foreach ($updates as $update) {
                try {
                    $res = DB::insert("INSERT INTO films (imdb_id, prod_year, rating)
                                                VALUES ('$update[imdb_id]', '$update[prod_year]', '$update[rating]')");
                } catch (Exception $e) {
                    $res = false;
                }
                if (!$res) {
                    continue;
                }
                
                DB::insert("INSERT INTO titles (imdb_id, en_title, uk_title, ru_title) VALUES ('$update[imdb_id]', (?), (?), (?))",
                    [$update['titles']['en_title'], $update['titles']['uk_title'], $update['titles']['ru_title']]);
                
                DB::insert("INSERT INTO posters (imdb_id, en_poster, uk_poster, ru_poster) VALUES ('$update[imdb_id]', (?), (?), (?))",
                    [$update['posters']['en_poster'], $update['posters']['uk_poster'], $update['posters']['ru_poster']]);
                
                foreach ($update['genres'] as $genre) {
                    DB::insert("INSERT INTO genres (imdb_id, genre)
                                                VALUES ('$update[imdb_id]', '$genre')");
                }
                $i++;
            }
            echo $i . ' films added, ' . (count($updates) - $i) . ' DB has already' . PHP_EOL;
            
            $films = DB::select("SELECT * FROM films");
            
            echo count($films) . ' films in Hypertube DB' . PHP_EOL;
        }
    }
