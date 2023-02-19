<?php

namespace App\Interfaces;

interface CommentInterface
{
    public function AddComment(array $data);

    public function getProductComments($id);

    public function likeComments($id);

    public function getLikes($id);
}
