<?php

    namespace App\Http\Controllers;
    
    use GuzzleHttp\Client;
    use Illuminate\Http\Request;

    class MainPageController extends Controller
    {
        public function __construct()
        {
            $this->middleware('auth');
        }
        
        protected function index()
        {
            return view('main');
        }
        
        protected function searchByTitle(Request $request)
        {
            $language = session()->get('locale');
            
            $query = $request->get('title');
            $client = new Client();
    
            $key = config('keys.tmdb');
            $response = $client->request('GET',
                "https://api.themoviedb.org/3/search/movie?api_key=$key&language=$language&query=$query&page=1&include_adult=false", [
                ]);
    
            dd(json_decode($response->getBody()));
        }
        
        protected function imdb(Request $request)
        {
            $target = $request->get('request');
            $client = new Client([
                'headers' => [
                    'x-rapidapi-host' => 'movie-database-imdb-alternative.p.rapidapi.com',
                    'x-rapidapi-key' => config('keys.imdb')
                ],
            ]);
          
           $response = $client->request('GET', 'https://movie-database-imdb-alternative.p.rapidapi.com/', [
                   'query' => [
                       'page' => '2',
                       'r' => 'json',
                       's' => $target
                   ]
               ]);
           
           dd(json_decode($response->getBody()));
           
        }
        
        protected function tmdb(Request $request) {
            $query = $request->get('request');
            $client = new Client();

            $key = config('keys.tmdb');
            $response = $client->request('GET',
                "https://api.themoviedb.org/3/search/movie?api_key=$key&language=en-US&query=$query&page=2&include_adult=false", [
            ]);

            dd(json_decode($response->getBody()));
        }
    }
