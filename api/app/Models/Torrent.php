<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;
use Illuminate\Database\Eloquent\SoftDeletes;

class Torrent extends Model
{
    use SoftDeletes;

    protected $table = "torrent";

    protected $primaryKey = "torrent_id";

    protected $fillable = [
        'movie_id',
        'url',
        'hash',
        'quality',
        'type',
        'size',
        'date_uploaded'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'movie_id', 'movie_id');
    }

    public function getSizeAttribute($value)
    {
        return \number_format($value / (1024*1024), 2, '.', '') . 'MB';
    }
}
