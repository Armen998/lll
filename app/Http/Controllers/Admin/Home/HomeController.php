<?php

namespace App\Http\Controllers\Admin\Home;

use App\Http\Controllers\Controller;
use App\Services\Admin\Home\HomeService;

class HomeController extends Controller
{
    protected $service;

    public function __construct(HomeService $service)
    {
        $this->service = $service;
    }

    //Home
    public function index()
    {
        $data = $this->service->index();

        return view('Admin/Home.index', ['categories' => $data['categories'], 'inactiveCategories' => $data['inactiveCategories'], 'activeCategories' => $data['activeCategories'], 'inactivePosts' => $data['inactivePosts'], 'activePosts' => $data['activePosts'], 'posts' => $data['posts'],'adminUsers' => $data['adminUsers'], 'regularUsers' => $data['regularUsers']]);
    }

    //Logout
    public function logout()
    {
        $this->service->logout();

        return redirect()->route('admin.login');
    }
}
