<?php

namespace App\Services\Web\Home;

use App\Models\Category;

class HomeService
{

    protected $categoryModel;

    public function __construct( Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }
   
    public function index()
    {
        $categories = $this->categoryModel::with([
            'user', 
            'postCategoris.post.user',
            'postCategoris.post.postComments',
            'postCategoris.post.postOpinion' => function ($query) {
                $query->where(['user_id' => auth('web')->id()]);
            }
        ])->get();

        return [
            'categories' => $categories,
        ];
    }

    public function logout()
    {
        auth('web')->logout();
    }
}
