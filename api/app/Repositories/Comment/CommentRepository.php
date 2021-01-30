<?php

namespace App\Repositories\Comment;

use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\Comment;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function model()
    {
        return Comment::class;
    }
}
