<?php

namespace App\Http\Controllers\Web\Posts;

use App\Http\Controllers\Controller;
use App\Services\Web\Posts\PostsOpinionsService;

class PostsOpinionsController extends Controller
{
    protected $service;


    public function __construct(PostsOpinionsService $service)
    {
        $this->service = $service;
    }

    //Like
    public function postsLike($id)
    {
        if ($this->service->like($id)) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    //Dislike
    public function postsDislike( $id)
    {
        if ($this->service->dislike($id)) {
            return redirect()->back();
        }
        return redirect()->back();
    }
}
