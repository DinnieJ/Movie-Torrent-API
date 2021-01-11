<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Torrent;

class Movie extends Model
{
    use SoftDeletes;

    protected $table = "movie";
    protected $primaryKey = "movie_id";

    protected $fillable = [
        'title',
        'title_eng',
        'year',
        'rating',
        'description',
        'background_img',
        'cover_img',
        'url',
        'source_movie_id',
        'source'
    ];

    public function torrents()
    {
        return $this->hasMany(Torrent::class, 'movie_id')
                    ->select([
                        'torrent_id',
                        'url',
                        'quality',
                        'type',
                        'size'
                    ]);
    }
}
