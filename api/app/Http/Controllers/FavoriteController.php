<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Favorite\FavoriteRepositoryInterface;
use App\Http\Requests\Favorite\AddFavoriteRequest;

class FavoriteController extends BaseController
{
    protected $favoriteRepository;

    public function __construct(
        FavoriteRepositoryInterface $favoriteRepository
    ) {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function addFavorite(AddFavoriteRequest $request)
    {
        $movie_id = $request->get('movie_id');
        $user_id = $this->getAuthUser()->id;
        $favorite = $this->favoriteRepository->findWhere([
            'movie_id' => $movie_id,
            'user_id' => $user_id
        ])->first();
        if (!$favorite) {
            $newFavorite = $this->favoriteRepository->create([
                'movie_id' => $movie_id,
                'user_id' => $user_id
            ]);
    
            if ($newFavorite) {
                return response()->json([
                    'message' => 'Add successful!'
                ], 200);
            }
    
            return response()->json([
                'message' => 'Something went wrong !'
            ], 500);
        }

        return response()->json([
            'message' => 'You already added this to your favorite'
        ], 403);
    }

    public function removeFavorite(AddFavoriteRequest $request)
    {
        $movie_id = $request->get('movie_id');
        $user_id = $this->getAuthUser()->id;
        $favorite = $this->favoriteRepository->findWhere([
            'movie_id' => $movie_id,
            'user_id' => $user_id
        ])->first();
        if ($favorite) {
            $favorite->delete();
            
            return response()->json([
                'message' => 'Deleted!'
            ], 200);
        }

        return response()->json([
            'message' => 'You are ready remove this movie from your favorite'
        ]);
    }
}
