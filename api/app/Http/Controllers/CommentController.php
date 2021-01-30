<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Comment\CommentRepositoryInterface;

class CommentController extends BaseController
{
    private $commentRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository
    ) {
        $this->commentRepository = $commentRepository;
    }

    public function addComment(Request $request)
    {
        $userId = $this->getAuthUser()->id;
        $movieId = $request->get('movie_id');
        $comment = $request->get('comment');

        $newComment = $this->commentRepository->create([
            'movie_id' => $movieId,
            'user_id' => $userId,
            'content' => $comment
        ]);

        if (!$newComment) {
            return response()->json([
                'message' => 'Failed to add to database'
            ], 422);
        }

        return response()->json([
            'message' => 'Success',
            'comment' => $newComment->toArray()
        ], 201);
    }

    public function removeComment(Request $request)
    {
        $userId = $this->getAuthUser()->id;
        $commentId = $request->get('comment_id');

        $comment = $this->commentRepository->find([
            'comment_id' => $commentId,
            'user_id' => $userId
        ]);

        if (!$comment) {
            return response()->json([
                'message' => 'Failed to delete comment'
            ], 401);
        }

        $comment->delete();

        return response()->json([
            'message' => 'Delete successful'
        ], 200);
    }
}
