<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\MoviesVisitHistory;

class UpdateMoviesVisitesTable
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        foreach ($event->movie->magnets as $magnet) {
            $visit = MoviesVisitHistory::updateOrCreate(
                ['magnet_hash' => md5($magnet)],
                ['last_visit' => date('Y-m-d')]
            );
        }
    }
}
