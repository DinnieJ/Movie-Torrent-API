<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Movie\MovieRepositoryInterface;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Movie\MovieCardResource;

class MovieController extends BaseController
{
    protected $movieRepository;
    public function __construct(
        MovieRepositoryInterface $movieRepository
    ) {
        $this->movieRepository = $movieRepository;
    }

    public function getAll(Request $request)
    {
        $movies = $this->movieRepository->paginate(30, [
            'movie_id',
            'title',
            'cover_img',
            'rating'
        ]);
        $data = array();
        foreach ($movies as $movie) {
            array_push($data, new MovieCardResource($movie));
        }
        return response()->json($data, 200);
    }

    public function getMovie(Request $request, $id)
    {
        $movie = $this->movieRepository->find($id);
        if ($movie) {
            $movie->torrents;
            
            return response()->json($movie, 200);
        }

        return response()->json(null, 404);
    }

    public function getUserMovie()
    {
        $movies = $this->getAuthUser()->movies ?? [];
        $data = array();

        foreach ($movies as $movie) {
            array_push($data, new MovieCardResource($movie));
        }
        return response()->json($data, 200);
    }
}
