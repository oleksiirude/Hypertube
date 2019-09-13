<?php

    namespace App\Console\Commands;

    use PDO;
    use Illuminate\Console\Command;

    class FillFilmsTables extends Command
    {
        /**
         * The name and signature of the console command.
         *
         * @var string
         */
        protected $signature = 'fillfilms:go';
    
        /**
         * The console command description.
         *
         * @var string
         */
        protected $description = 'Fill all grabbed film data to database';
    
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
            echo 'filling db: started' . PHP_EOL;
            
            $start = time();
            $con = new PDO("mysql:host=" . env('DB_HOST') . ";dbname=" . env('DB_DATABASE'),
                env('DB_USERNAME'),
                env('DB_PASSWORD'), [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_LOCAL_INFILE => true
                ]);
    
            $base_path = str_replace('\\', '/',base_path());
            $con->query("LOAD DATA LOCAL INFILE \"" . $base_path . '/storage/app/public/grabber/films.txt' . "\" INTO TABLE films FIELDS TERMINATED BY \";\" LINES TERMINATED BY \"\\n\"");
            $con->query("LOAD DATA LOCAL INFILE \"" . $base_path . '/storage/app/public/grabber/titles.txt' . "\" INTO TABLE titles FIELDS TERMINATED BY \";\" LINES TERMINATED BY \"\\n\"");
            $con->query("LOAD DATA LOCAL INFILE \"" . $base_path . '/storage/app/public/grabber/posters.txt' . "\" INTO TABLE posters FIELDS TERMINATED BY \";\" LINES TERMINATED BY \"\\n\"");
            $con->query("LOAD DATA LOCAL INFILE \"" . $base_path . '/storage/app/public/grabber/genres.txt' . "\" INTO TABLE genres FIELDS TERMINATED BY \";\" LINES TERMINATED BY \"\\n\"");
    
            $end = time();
            $result = $end - $start;
            
            echo 'consumed time: ' . $result . ' seconds' . PHP_EOL;
            echo 'done' . PHP_EOL;
        }
    }
