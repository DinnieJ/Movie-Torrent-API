<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Favorite extends Model
{
    protected $table = "favorite";
    
    protected $primaryKey = "favorite_id";

    protected $fillable = [
        'user_id',
        'movie_id'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
