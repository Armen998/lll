<?php

namespace App\Services\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostComment;
use App\Models\PostFavorite;
use App\Models\PostOpinion;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PostsService 
{
    protected $categoryModel;

    protected $postModel;

    protected $userModel;

    public function __construct( Category $categoryModel, Post $postModel ,User $userModel)
    {
        $this->categoryModel = $categoryModel;

        $this->postModel = $postModel;

        $this->userModel = $userModel;
    }
   
    public function index()
    {
        $categories = $this->categoryModel::with([
            'user', 
            'postCategoris.post.user',
            'postCategoris.post.postComments',
        ])->get();

        $inactiveCategories = $this->categoryModel::where(['status' => 0])->get();

        $activeCategories = $this->categoryModel::where(['status' => 1])->get();

        $inactivePosts = $this->postModel::where(['status' => 0])->get();

        $activePosts = $this->postModel::where(['status' => 1])->get();

        $posts = $this->postModel::get();

        $adminUsers = $this->userModel::where(['type' => 'admin'])->get(['id']);

        $regularUsers = $this->userModel::where(['type' => 'regular'])->get(['id']);

        return [
            'categories' => $categories, 
            'inactiveCategories' => $inactiveCategories, 
            'activeCategories' => $activeCategories, 
            'inactivePosts' => $inactivePosts, 
            'activePosts' => $activePosts, 
            'posts' => $posts,
            'adminUsers' => $adminUsers, 
            'regularUsers' => $regularUsers,
        ];
    }
    
     // Post block
     public function postBlock($id)
     {
         $post = $this->postModel::with(['user'])->where(['id' => $id])->first();
 
         $presentTyme = date('Y-m-d h:i:s', time());
 
         $posts_block = $this->postModel::where(['id' => $id])->update(['block_time' => $presentTyme, 'updated_at' => $post->updated_at]);
 
         if ($posts_block) {
             return  $post;
         }
         return false;
     }
 
     // Post Unlock
     public function postUnlock($id)
     {
         $post = $this->postModel::with(['user'])->where(['id' => $id])->first();
 
         $posts_block = $this->postModel::where(['id' => $id])->update(['block_time' => Null, 'updated_at' => $post->updated_at]);
 
         if ($posts_block) {
             return  $post;
         }
         return false;
     }
 
     //Post Favorite
     public function postFavorite($id)
     {
         $post = $this->postModel::with(['user'])->where(['id' => $id])->first();
 
         $postfavorite =  $this->postFavoriteModel::where(['user_id' => auth('admin')->id(), 'post_id' => $id])->first();
 
         if (empty($postfavorite)) {
             $this->postFavoriteModel::create([
                 'user_id' => auth('admin')->id(),
                 'post_id' => $id,
             ]);
             return  $post;
         }
         return false;
     }
 
     //Post Unfavotite
     public function postsUnfavorite($id)
     {
         $id = (int) $id;
         $post = $this->postModel::with(['user'])->where(['id' => $id])->first();
 
         $post_favorite = $this->postFavoriteModel::where(['user_id' => auth('admin')->id(), 'post_id' => $id])->delete();
 
         if ($post_favorite) {
             return $post;
         }
         return false;
     }
 
     //post Delete
     public function postDestroy($id)
     {
         $post = $this->postModel::with(['user'])->where(['id' => $id])->first();
 
         $deleteInPost = $this->postModel::find($id)->delete();
         
         if ($deleteInPost) {
             return $post;
         }
         return false;
     }
}
