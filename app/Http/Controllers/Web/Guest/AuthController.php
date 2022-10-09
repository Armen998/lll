<?php

namespace App\Http\Controllers\Web\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegistrationFormRequest;
use App\Services\Web\Guest\AuthService;

class AuthController extends Controller
{
    protected $service;

    public function __construct(AuthService $service)
    {
        $this->service = $service;
    }

    //Registration
    public function registration()
    {
        return view('Web.Guest.registration');
    }

    public function signup(RegistrationFormRequest $request)
    {
        $registredData = $request->validated();

        $signup = $this->service->signup($registredData);

        if ($signup) {
            return redirect()->route('login')->with(['thank' => 'Thank you for registering on our website']);
        }
        return redirect()->back()->with(['failure' => 'Registration failed']);
    }

    //Login
    public function login()
    {
        return view('Web.Guest.login');
    }

    public function signin(LoginFormRequest $request)
    {
        $authedData = $request->validated();

        if ($this->service->signin($authedData)) {
            return redirect()->route('home');
        }
        return redirect()->back()->with(['suspension' => 'Incorrect email or password']);
    }

}
