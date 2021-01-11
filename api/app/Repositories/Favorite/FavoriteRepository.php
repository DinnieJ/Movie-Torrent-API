<?php

namespace App\Repositories\Favorite;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Favorite;

class FavoriteRepository extends BaseRepository implements FavoriteRepositoryInterface
{
    public function model()
    {
        return Favorite::class;
    }
}
