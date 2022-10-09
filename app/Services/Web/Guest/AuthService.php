<?php

namespace App\Services\Web\Guest;

use App\Models\Article;
use App\Models\User;


class AuthService
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;

    }

    public function signup($registredData)
    {
        $userData = $this->userModel::create([
            'name' => $registredData['name'],
            'type' => 'regular',
            'email' => $registredData['email'],
            'age' => $registredData['age'],
            'password' => bcrypt($registredData['password'])
        ]);

        if ($userData) {
            return true;
        }
        return false;
    }

    public function signin($authedData)
    {
        if (auth('web')->attempt($authedData)) {
            return true;
        }
        return false;
    }
}
