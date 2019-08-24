<?php

    namespace App\Http\Controllers;
    
    use GuzzleHttp\Client;
    use GuzzleHttp\Psr7\Request;

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
        
        protected function show()
        {
            $client = new Client([
                'headers' => [
                    'x-rapidapi-host' => 'movie-database-imdb-alternative.p.rapidapi.com',
                    'x-rapidapi-key' => config('keys.imdb')
                ],
            ]);
          
           $response = $client->request('GET', 'https://movie-database-imdb-alternative.p.rapidapi.com/', [
                   'query' => [
                       'i' => 'tt4154796',
                       'r' => 'json'
                   ]
               ]);
           dd($response->getBody());
            
            
            
            $request = new Request('GET', 'https://movie-database-imdb-alternative.p.rapidapi.com');
            
//            $client = new Client();
//            $request = new Client\Request();
//
//            $request->setRequestUrl('https://movie-database-imdb-alternative.p.rapidapi.com/');
//            $request->setRequestMethod('GET');
//            $request->setQuery(new QueryString(array(
//                'i' => 'tt4154796',
//                'r' => 'json'
//            )));
//
//            $request->setHeaders(array(
//                'x-rapidapi-host' => 'movie-database-imdb-alternative.p.rapidapi.com',
//                'x-rapidapi-key' => config('keys.imdb')
//            ));
//
//            $client->enqueue($request)->send();
//            $response = $client->getResponse();
//
//            dd($response->getBody());
        }
    }
