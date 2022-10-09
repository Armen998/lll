<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginFormRequest;
use App\Services\Admin\Auth\AuthService;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    //Login
    public function login()
    {
        return view('Admin/Guest.login');
    }

    public function signin(AdminLoginFormRequest $request)
    {
        $createdData = $request->validated();

        if ($this->service->signin($createdData)) {
            return redirect()->route('admin.home');
        }
        return redirect()->back()->with(['suspension' => 'Incorrect email or password']);
    }
}
