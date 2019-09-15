<?php

    namespace App\Http\Controllers;
    
    class APIController extends Controller
    {
        protected $lang;
        
        public function __construct($lang)
        {
            $this->lang = $lang . '_title';
        }
        
        public function getMovieByImdbId($imdbId)
        {
            dd($imdbId);
        }
    }
