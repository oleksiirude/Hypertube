<?php

namespace App\Console\Commands;

use App\MoviesVisitHistory;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DeleteMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deletemovies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deleted movies with last visit more 30 days';

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
        $movies = MoviesVisitHistory::where('last_visit', '<', Carbon::now()->subDays(30))->get();

        foreach ($movies as $movie) {
            $isDel = \File::deleteDirectory(base_path().env('MOVIES_DIR').$movie->magnet_hash);
            sleep(5);
            if ($isDel) {
                $movie->delete();
            } else {
                echo "Something went wrong. Movie directory was not deleted.\n";
            }
        }
        echo 'Was deleted '.count($movies)." movies\n";
    }
}
