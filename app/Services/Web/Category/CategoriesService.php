<?php

namespace App\Services\Web\Category;

use App\Models\Category;

class CategoriesService
{
    protected $categoryModel;

    public function __construct(Category $categoryModel )
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

    public function create($createCategoryData)
    {
        $cretedData = [
            'user_id' => auth('web')->id(),
            'title' => $createCategoryData['title'],
        ];

        if ($this->categoryModel::create($cretedData)) {
            return true;
        }
        return false;
    }
}
