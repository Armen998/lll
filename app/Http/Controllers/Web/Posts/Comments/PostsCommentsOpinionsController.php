<?php

namespace App\Http\Controllers\Web\Posts\Comments;

use App\Http\Controllers\Controller;
use App\Services\Web\Posts\Comments\PostsCommentsOpinionsService;

class PostsCommentsOpinionsController extends Controller
{
    protected $service;


    public function __construct(PostsCommentsOpinionsService $service)
    {
        $this->service = $service;
    }

    //Like
    public function postsCommentsLike($id)
    {
        if ($this->service->like($id)) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    //Dislike
    public function postCommentDislike( $id)
    {
        if ($this->service->dislike($id)) {
            return redirect()->back();
        }
        return redirect()->back();
    }
}
