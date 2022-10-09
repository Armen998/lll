<?php

namespace App\Http\Controllers\Web\Posts;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostsFormRequest;
use App\Http\Requests\PostStatedCategoryFormRequest;
use App\Http\Requests\PostsUpdatedFormRequest;
use App\Services\Web\Posts\PostsService;

class PostsController extends Controller
{
    protected $service;

    public function __construct(PostsService $service,)
    {
        $this->service = $service;
    }

    //Add Post
    public function create()
    {
        $data = $this->service->all_categoris();

        return view('Web/Posts.create', ['categories' => $data['categories']]);
    }

    public function store(PostsFormRequest $request)
    {
        $createdData = $request->validated();

        $created = $this->service->create($createdData);

        if ($created) {
            return redirect()->route('home');
        }
        return redirect()->back();
    }

    //Add Post Stated Category
    public function statedCeate($id)
    {
        $data = $this->service->statedCategory($id);

        return view('Web/Posts.statedCreate', ['categories' => $data['categories']]);
    }

    public function statedStore(PostStatedCategoryFormRequest $request, $id)
    {

        $createdData = $request->validated();

        $created = $this->service->statedCreate($createdData, $id);

        if ($created) {
            return redirect()->route('home');
        }
        return redirect()->back();
    }

    // Post View
    public function view($id)
    {
        $data = $this->service->view($id);

        return view('Web/Posts.view', ['categories' => $data['categories']]);
    }

    public function edit($id)
    {
        $data = $this->service->updatedPost($id);

        if ($data) {
            return view('Web/posts.create', ['categories' => $data['categories'], 'posts' => $data['posts']]);
        }
        return redirect()->back();
    }

    //Updated Post
    public function update(PostsUpdatedFormRequest $request, $id)
    {
        $updatedData = $request->validated();

        $updated = $this->service->update($id, $updatedData);

        if ($updated) {
            return redirect()->back()->with(['changed' => 'your post information has been changed.']);
        }
        return redirect()->back()->with(['indication' => 'Your data has not changed.']);
    }

    //Delete Post
    public function destroy($id)
    {
        $delete = $this->service->destroy($id);

        if ($delete) {
            return redirect('home')->with(['deleted' => 'your post  has been deleted.']);;
        }
        return redirect()->back();
    }
}
