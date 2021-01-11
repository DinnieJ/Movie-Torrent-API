<?php

namespace App\Repositories\Movie;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Movie;

class MovieRepository extends BaseRepository implements MovieRepositoryInterface
{
    public function model()
    {
        return Movie::class;
    }
}
