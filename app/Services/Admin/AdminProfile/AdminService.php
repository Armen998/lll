<?php

namespace App\Services\Admin\AdminProfile;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    protected $userModel;

    protected $postModel;

    public function __construct(User $userModel, Post $postModel)
    {
        $this->userModel = $userModel;

        $this->postModel = $postModel;
        
    }

    //Admin 
    public function index()
    {
        $posts = $this->postModel::with([
            'user', 'postComments', 'postOpinion',
            'postFavorite' => function ($query) {
                $query->where(['user_id' => auth('admin')->id()]);
            }
        ])->get();

        $adminUsers = $this->userModel::with(['posts', 'post_comments', 'postOpinion', 'postFavorite'])->where(['type' => 'admin'])->get(['id', 'type', 'name', 'age', 'email', 'avatar',  'created_at']);

        $regularUsers = $this->userModel::with(['posts', 'post_comments', 'postOpinion', 'postFavorite'])->where(['type' => 'regular'])->get(['id', 'type', 'name', 'age', 'email', 'avatar',  'created_at']);

        return [
            'posts' => $posts,
            'regularUsers' => $regularUsers,
            'adminUsers' => $adminUsers,
        ];
    }

    public function adminDataUpdate($updatedData)
    {
        $userData = $this->userModel::where(['id' => auth('admin')->id()])->first(['name', 'age', 'email']);

        $checkEmail = $this->userModel::where(['email' => $updatedData['email']])->first(['email']);

        if (!empty([$userData, $updatedData]) && empty($checkEmail) || $checkEmail->email === auth('admin')->user()->email) {
            $this->userModel::find(auth('admin')->id())->update($updatedData);
            return true;
        }
        return false;
    }

    public function adminPasswordUpdate($updatedPasswordData)
    {
        if (Hash::check($updatedPasswordData['current_password'], auth('web')->user()->password)) {
            if ($updatedPasswordData['new_password'] === $updatedPasswordData['confirm_new_password']) {
                $this->userModel::where(['id' => auth('web')->id()])->update(['password' => bcrypt($updatedPasswordData['new_password'])]);
                return true;
            }
        }
        return false;
    }
}
