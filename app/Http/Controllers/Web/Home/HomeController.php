<?php

namespace App\Http\Controllers\Web\Home;

use App\Http\Controllers\Controller;
use App\Services\Web\Home\HomeService;

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

        return view('Web/Home.index', ['categories' => $data['categories']]);
    }

    //Logout
    public function logout()
    {
        $this->service->logout();

        return redirect()->route('login');
    }
}
