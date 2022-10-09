<?php

namespace App\Http\Controllers\Web\Category;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryFormRequest;
use App\Services\Web\Category\CategoriesService;

class CategoriesController extends Controller
{
    protected $service;

    public function __construct(CategoriesService $service, )
    {
        $this->service = $service;
    }

    public function create() 
    {
        $data = $this->service->index();

        return view('Web.Categories.create', ['categories' => $data['categories']]);
    }

    public function store(CategoryFormRequest $request) 
    {
        $createCategoryData = $request->validated();

        if ($this->service->create($createCategoryData)) {
            return redirect()->route('home');
        } 
        return redirect()->back();

    }
}
