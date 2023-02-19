<?php

namespace App\Repositories;

use App\Models\CommentLikes;
use App\Models\ProductComments;

class CommentRepository implements \App\Interfaces\CommentInterface
{
    public function AddComment(array $data)
    {
        return ProductComments::query()->create($data);
    }

    public function getProductComments($id)
    {
        return ProductComments::query()->where('product_id', $id)->with(['user', 'likes'])->get();
    }

    public function likeComments($id)
    {
        return CommentLikes::query()->create([
            'product_comment_id' => $id,
            'user_id' => auth('sanctum')->id(),
        ]);
    }

    public function getLikes($id)
    {
        return CommentLikes::query()->where('product_comment_id', $id)->with('user')->get();
    }
}
