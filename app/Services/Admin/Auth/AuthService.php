<?php

namespace App\Services\Admin\Auth;

use App\Models\Article;
use App\Models\ArticleComment;
use App\Models\ArticleFavorite;
use App\Models\ArticleOpinion;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthService
{
    protected $userModel;

    public function __construct(User $userModel)
    {
        $this->userModel = $userModel;

    }

    //Admin Login
    public function signin($createdData)
    {
        $adminData = $this->userModel::where(['email' => $createdData['email']])->first();

        if (!empty($adminData) && $adminData->type === 'admin' && auth('admin')->attempt($createdData)) {
            return true;
        }
        return false;
    }

   
}
