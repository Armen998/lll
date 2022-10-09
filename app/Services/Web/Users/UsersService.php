<?php

namespace App\Services\Web\Users;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersService
{
    protected $userModel;

    protected $categoryModel;
    
    public function __construct(User $userModel, Category $categoryModel  )
    {
        $this->categoryModel = $categoryModel;

        $this->userModel = $userModel;

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

    public function posts()
    {
        $categories = $this->categoryModel::with([
            'user',
            'postCategoris.post.user',
            'postCategoris.post.postComments',
            'postCategoris.post.postOpinion' => function ($query) {
                $query->where(['user_id' => auth('web')->id()]);
            }
        ])->where(['user_id' => auth('web')->id()])->get();

        return [
            'categories' => $categories,
        ];
    }

    public function update($updatedData)
    {
        $userData = $this->userModel::where(['id' => auth('web')->id()])->first(['name', 'age', 'email']);

        $checkEmail = $this->userModel::where(['email' => $updatedData['email']])->first(['email']);

        if (!empty([$userData, $updatedData]) && empty($checkEmail) || $checkEmail->email === auth('web')->user()->email) {
            $this->userModel::find(auth('web')->id())->update($updatedData);
            return true;
        }
        return false;
    }

    public function passwordUpdate($updatedPasswordData)
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
