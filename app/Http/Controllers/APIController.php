<?php

    namespace App\Http\Controllers;
    
    use Exception;
    use GuzzleHttp\Client;

    class APIController extends Controller
    {
        protected $client;
        protected $lang;
        
        public function __construct()
        {
            $this->lang = LocaleController::getLang();
            $this->client = new Client();
        }
        
        public function getMovieByImdbId($imdbId)
        {
            try {
                $response = $this->client->request('GET',
                    'https://yts.am/api/v2/list_movies.json', [
                        'query' => [
                            'query_term' => $imdbId,
                        ]
                    ]);
                
                $movie = (json_decode($response->getBody()))->data;
      
                return $movie->movie_count ? $this->getAdditionalDataForMovie($movie->movies[0]) : false;
            } catch (Exception $e) {
                return false;
            }
        }
        
        protected function getAdditionalDataForMovie($movie)
        {
            try {
                $response = $this->client->request('GET',
                    'https://api.themoviedb.org/3/find/' . $movie->imdb_code, [
                        'query' => [
                            'external_source' => 'imdb_id',
                            'language' => $this->lang,
                            'api_key' => config('keys.tmdb')
                        ]
                    ]);
                $data = json_decode($response->getBody());
        
                $response = $this->client->request('GET',
                    'https://api.themoviedb.org/3/movie/' . $data->movie_results[0]->id, [
                        'query' => [
                            'external_source' => 'imdb_id',
                            'language' => $this->lang,
                            'api_key' => config('keys.tmdb'),
                            'append_to_response' => 'credits'
                        ]
                    ]);
                $data = json_decode($response->getBody());
                
                if (preg_match('/^.*[0-9a-zа-яёїі :!?,.]{1,}.*$/iu', $data->title))
                    $movie->title = $data->title;
                $movie->large_cover_image = BASE_URL . BIG . $data->poster_path;
                if ($data->overview)
                    $movie->summary = $data->overview;
               
                $movie->actors = $this->getActors($data->credits->cast);
                $movie->director = $this->getDirector($data->credits->crew);
                $movie->genres = $this->getGenres($data->genres);
                
                if (isset($data->production_companies[0]))
                    $movie->studio = $data->production_companies[0]->name;
                else
                    $movie->studio = false;
                
                return $movie;
            } catch (Exception $e) {
                return false;
            }
        }
        
        protected function getActors($cast)
        {
            $cast = array_slice($cast, 0, 5);
            
            foreach ($cast as $actor) {
                if (!$actor->profile_path)
                    $actor->profile_path = false;
                else
                    $actor->profile_path = BASE_URL . SMALL . $actor->profile_path;
            }
            return $cast;
        }
        
        protected function getDirector($crew)
        {
            foreach ($crew as $item) {
                if ($item->job === 'Director') {
                    if (!$item->profile_path)
                        $item->profile_path = false;
                    else
                        $item->profile_path = BASE_URL . SMALL . $item->profile_path;
                    return $item;
                }
            }
            return false;
        }
        
        protected function getGenres($genres)
        {
            foreach ($genres as $genre)
                $array[] = $genre->id;
            
            return $array;
        }
    }
