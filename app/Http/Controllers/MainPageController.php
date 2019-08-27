<?php

    namespace App\Http\Controllers;
    
    use GuzzleHttp\Client;
    use Illuminate\Http\Request;

    class MainPageController extends Controller
    {
        private $tmdb;
        
        public function __construct()
        {
            $this->middleware('auth');
            $this->tmdb = new TMDBController();
        }
        
        protected function index()
        {
            return view('main');
        }
        
        protected function searchByTitle(Request $request)
        {
            $results = $this->tmdb->getByTitle($request->get('title'));
    
            dd($results);
            
            return view('main', ['content' => $results->results]);
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
    }
