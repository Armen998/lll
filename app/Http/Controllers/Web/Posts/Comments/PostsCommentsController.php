<?php

namespace App\Http\Controllers\Web\Posts\Comments;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostsCommentFormRequest;
use App\Services\Web\Posts\Comments\PostsCommentsService;

class PostsCommentsController extends Controller
{
    protected $service;

    public function __construct(PostsCommentsService $service)
    {
        $this->service = $service;
    }

    public function store(PostsCommentFormRequest $request, $id)
    {
        $createdData = $request->validated();

        $created = $this->service->create($createdData, $id);

        if ($created) {
            return redirect()->back();
        }
        return redirect()->back();
    }

    public function reply(PostsCommentFormRequest $request, $id, $comment_id)
    {
        $createdData = $request->validated();

        $created = $this->service->reply( $comment_id, $createdData, $id);

        if ($created) {
            return redirect()->back();
        }
        return redirect()->back();
    }
}
