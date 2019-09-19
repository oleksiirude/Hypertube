<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MoviesVisitHistory extends Model
{
    protected $table = 'movies_history';

    protected $fillable = [
        'magnet_hash', 'last_visit'
    ];

    protected $primaryKey = 'id';

    public $timestamps = false;
}
