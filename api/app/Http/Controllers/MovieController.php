<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Movie\MovieRepositoryInterface;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\Movie\MovieCardResource;
use App\Models\Movie;
use DB;

class MovieController extends BaseController
{
    protected $movieRepository;
    public function __construct(
        MovieRepositoryInterface $movieRepository
    ) {
        $this->movieRepository = $movieRepository;
    }

    public function testMovie()
    {
    }
    public function getAll(Request $request)
    {
        $movies = null;
        if ($user = $this->getAuthUser()) {
            $movies = $this->movieRepository
                      ->getMovieCardAuth($user->id)
                      ->paginate(Movie::PAGE_LIMIT);
        } else {
            $movies = $this->movieRepository->paginate(Movie::PAGE_LIMIT, [
                'movie_id',
                'title',
                'cover_img',
                'rating'
            ]);
        }

        //return response()->json($movies, 200);
        $data = array();
        $totalPage = $this->movieRepository->getPageNumber();

        foreach ($movies as $movie) {
            array_push($data, new MovieCardResource($movie->toArray()));
        }

        return response()->json([
            'current_page' => \intval($request['page']) ?? 1,
            'total_page' => $totalPage,
            'data' => $data
        ], 200);
    }

    public function getMovie(Request $request, $id)
    {
        $movie = null;
        if ($user = $this->getAuthUser()) {
            $movie = $this->movieRepository->getMovieDetail($id, $user->id);
        } else {
            $movie = $this->movieRepository->getMovieDetail($id);
        }
        
        if ($movie) {
            $dataArr = $movie->toArray();
            $movie->favorited = isset($dataArr['favorites']) && count($dataArr['favorites']);
            
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

    public function getRandomFive(Request $request)
    {
        $movies = $this->movieRepository->getTopFiveMovies();

        $data = array();

        foreach ($movies as $key=>$item) {
            array_push($data, new MovieCardResource($item));
        }

        return response()->json($data, 200);
    }

    public function searchMovie(Request $request)
    {
        $keyword = $request['keyword'];
        $page = $request->get('page') ?? 1;

        if ($user = $this->getAuthUser()) {
            $movies = $this->movieRepository
                           ->getMovieByTitle($keyword, $user->id);
        } else {
            $movies = $this->movieRepository
                           ->getMovieByTitle($keyword);
        }

        $moviesResult = $movies->paginate(Movie::PAGE_LIMIT);
        $totalPage = $movies->count();
        $data = array();

        foreach ($moviesResult as $key=>$item) {
            array_push($data, new MovieCardResource($item->toArray()));
        }

        return response()->json([
            'current_page' => \intval($page),
            'total_page' => ceil($totalPage / Movie::PAGE_LIMIT),
            'data' => $data
        ], 200);
    }
}
