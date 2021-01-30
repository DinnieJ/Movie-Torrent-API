<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Torrent;
use App\Models\Favorite;
use App\Models\Comment;

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

    protected $appends = [
        'total_favorite',
    ];

    const PAGE_LIMIT = 30;

    public function torrents()
    {
        return $this->hasMany(Torrent::class, 'movie_id', 'movie_id');
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class, 'movie_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, 'movie_id', 'movie_id');
    }
 

    public function getTotalFavoriteAttribute($value)
    {
        return $this->hasMany(Favorite::class, 'movie_id')->count();
    }
}
