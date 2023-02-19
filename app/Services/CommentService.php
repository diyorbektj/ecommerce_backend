<?php

namespace App\Services;

use App\Models\CommentLikes;
use App\Repositories\CommentRepository;

class CommentService
{
    private CommentLikes $commentLikes;

    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository, CommentLikes $commentLikes)
    {
        $this->commentRepository = $commentRepository;
        $this->commentLikes = $commentLikes;
    }

    public function like($id)
    {
        $user_like = $this->commentLikes->query()->where('product_comment_id', $id)->where('user_id', auth('sanctum')->id())->first();
        if ($user_like) {
            $user_like->delete();

            return response()->json(['message' => 'You unliked this comment']);
        } else {
            $this->commentRepository->likeComments($id);

            return response()->json(['message' => 'You liked this comment']);
        }
    }
}
