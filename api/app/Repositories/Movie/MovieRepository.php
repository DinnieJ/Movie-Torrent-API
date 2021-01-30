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

    public function getTopFiveMovies()
    {
        return $this->model->inRandomOrder()->limit(5)->get();
    }

    public function searchMoviesByQuery($query)
    {
        return $this->findWhere([
            ['title', 'LIKE', '%' . $query . '%']
        ]);
    }

    public function getPageNumber()
    {
        return \intval(\ceil($this->count() / Movie::PAGE_LIMIT));
    }


    public function getMovieCardAuth($userId)
    {
        return $this->with(['favorites' => function ($query) use ($userId) {
            return $query->whereHas('users', function ($uQuery) use ($userId) {
                $uQuery->where('id', $userId);
            })->get();
        }]);
    }

    public function getMovieByTitle($title, $userId = null)
    {
        if ($userId) {
            return $this->scopeQuery(function ($query) use ($title) {
                return $query->where('title', 'LIKE', '%' . $title . '%');
            })->with(['favorites' => function ($query) use ($userId) {
                return $query->whereHas('users', function ($uQuery) use ($userId) {
                    $uQuery->where('id', $userId);
                })->get();
            }]);
        } else {
            return $this->scopeQuery(function ($query) use ($title) {
                return $query->where('title', 'LIKE', '%' . $title . '%');
            });
        }
    }

    public function getMovieDetail($id, $userId = null)
    {
        $withCondition = [
            'torrents' => function ($tQuery) use ($id) {
            },
            'comments' => function ($query) {
                $query->orderBy('created_at', 'DESC');
            },
        ];

        $movie = $this->model->with($withCondition);

        if ($userId) {
            $movie = $movie->with([
                'favorites' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }
            ]);
        }

        $movie = $movie->where('movie.movie_id', $id)->first();


        return $movie;
    }
}
