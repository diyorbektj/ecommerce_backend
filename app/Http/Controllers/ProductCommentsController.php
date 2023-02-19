<?php

namespace App\Http\Controllers;

use App\DTO\CommentDTO;
use App\Http\Requests\CommentsRequest;
use App\Http\Resources\CommentsResource;
use App\Models\CommentLikes;
use App\Repositories\CommentRepository;
use App\Services\CommentService;

class ProductCommentsController extends Controller
{
    private CommentRepository $comment;

    private CommentLikes $likes;

    private CommentService $service;

    public function __construct(CommentRepository $comment, CommentLikes $likes, CommentService $service)
    {
        $this->comment = $comment;
        $this->likes = $likes;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function store(CommentsRequest $request, int $id)
    {
        $data = CommentDTO::toArray($request->validated(), $id);
        $comment = $this->comment->AddComment($data);

        return new CommentsResource($comment);
    }

    public function show($id)
    {
        $comments = $this->comment->getProductComments($id);

        return CommentsResource::collection($comments);
    }

    public function getlikes(int $id)
    {
        $likes = CommentLikes::query()->where('product_comment_id', $id)->count();

        return response()->json(['count' => $likes]);
    }

    public function like(int $id)
    {
        return $this->service->like($id);
    }
}
