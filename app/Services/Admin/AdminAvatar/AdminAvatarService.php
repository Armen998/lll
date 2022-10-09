<?php

namespace App\Services\Admin\AdminAvatar;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminAvatarService
{
    protected $userModel;

    protected $postModel;

    public function __construct(User $userModel, Post $postModel)
    {
        $this->userModel = $userModel;

        $this->postModel = $postModel;
        
    }

    //Avatar Add
    public function addAvatar()
    {
        $user = $this->userModel::with(['posts' => function ($query) {
            $query->where(['user_id' => auth('web')->id()]);
        }])->where(['id' => auth('web')->id()])->get(['id', 'name', 'age', 'email',]);

        return [
            'user' => $user,
        ];
    }

    //Avatar create
    public function createAvatar($createdData)
    {
        $avatarPath = $createdData['avatar']->store('avatars', 'public');

        $user = $this->userModel::find(auth('admin')->id());

        $user->avatar = $avatarPath;

        if ($user->save()) {
            return true;
        } else {
            return false;
        }
    }

    //Avatar Delete
    public function avatarDestroy()
    {
        $user = $this->userModel::find(auth('admin')->id());

        DB::transaction(function () use ($user) {
            $deleteInStorage = Storage::disk('public')->delete($user->avatar);

            $user->avatar = Null;

            if ($user->update() && $deleteInStorage) {
                DB::commit();
                return true;
            }
        }, 3);
        return false;
    }
    
}
