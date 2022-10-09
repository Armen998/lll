<?php

namespace App\Services\Admin\Home;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;

class HomeService
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

    public function logout()
    {
        auth('admin')->logout();
    }
}
