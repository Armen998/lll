<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Services\Admin\Posts\PostsService;

class PostsController extends Controller
{
    protected $service;

    public function __construct(PostsService $service)
    {
        $this->service = $service;
    }
    
    //Post
    public function index()
    {
        $data = $this->service->index();

        return view('Admin/Posts.posts',  ['categories' => $data['categories'], 'inactiveCategories' => $data['inactiveCategories'], 'activeCategories' => $data['activeCategories'], 'inactivePosts' => $data['inactivePosts'], 'activePosts' => $data['activePosts'], 'posts' => $data['posts'],'adminUsers' => $data['adminUsers'], 'regularUsers' => $data['regularUsers']]);
    }

    // Post block
    public function postBlock($id)
    {
        $postBlock = $this->service->postBlock($id);

        if ($postBlock) {
            $tmp = $postBlock->user->name . '\'s ' . ' ' . ' \'\'' . $postBlock->title . '\'\'' . ' post for a week blocked.';
            return redirect('admin/posts')->with(['blocked' => $tmp]);
        }
        return redirect()->back();
    }

    // Post unlock
    public function postUnlock($id)
    {
        $postBlock = $this->service->postUnlock($id);

        if ($postBlock) {
            $tmp = $postBlock->user->name . '\'s ' . ' ' . ' \'\'' . $postBlock->title . '\'\'' . ' post unlocked.';
            return redirect('admin/posts')->with(['unlocked' => $tmp]);
        }
        return redirect()->back();
    }

    // Post favorite
    public function postFavorite($id)
    {
        $postFavorite = $this->service->postFavorite($id);

        if ($postFavorite) {
            $tmp = $postFavorite->user->name . '\'s ' . ' ' . ' \'\'' . $postFavorite->title . '\'\'' . ' post favorited.';
            return redirect('admin/posts')->with(['favorited' => $tmp]);
        }
        return redirect()->back();
    }

    public function postUnfavorite($id)
    {
        $postsUnfavorite = $this->service->postsUnfavorite($id);

        if ($postsUnfavorite) {
            $tmp = $postsUnfavorite->user->name . '\'s ' . ' ' . ' \'\'' . $postsUnfavorite->title . '\'\'' . ' post unfavorited.';
            return redirect('admin/posts')->with(['unfavorited' => $tmp]);
        }
        return redirect()->back();
    }

    //Post Delete
    public function postDestroy($id)
    {
        $delete = $this->service->postDestroy($id);

        if ($delete) {
            $tmp = $delete->user->name . '\'s ' . ' ' . ' \'\'' . $delete->title . '\'\'' . ' post has been deleted.';
            return redirect('admin/posts')->with(['post_deleted' => $tmp]);
        }
        return redirect()->back();
    }
}
