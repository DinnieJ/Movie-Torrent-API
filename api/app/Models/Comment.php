<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
    protected $table = "comment";

    protected $primaryKey = "comment_id";

    protected $fillable = [
        'user_id',
        'movie_id',
        'content'
    ];

    protected $appends = ['username'];

    public function getUsernameAttribute()
    {
        $userInfo = $this->belongsTo(User::class, 'user_id', 'id')->first();
        return $userInfo->name . "(" . $userInfo->email . ")";
    }
}
