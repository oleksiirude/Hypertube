<?php

    namespace App\Events;
    
    use Illuminate\Queue\SerializesModels;
    use Illuminate\Broadcasting\PrivateChannel;
    use Illuminate\Foundation\Events\Dispatchable;
    use Illuminate\Broadcasting\InteractsWithSockets;
    
    class NewMovieVisitEvent
    {
        use Dispatchable, InteractsWithSockets, SerializesModels;
        public $movie;
        /**
         * Create a new event instance.
         *
         * @return void
         */
        public function __construct($movie)
        {
            $this->movie = $movie;
        }
    
        /**
         * Get the channels the event should broadcast on.
         *
         * @return \Illuminate\Broadcasting\Channel|array
         */
        public function broadcastOn()
        {
            return new PrivateChannel('channel-name');
        }
    }
