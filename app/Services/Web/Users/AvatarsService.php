<?php

namespace App\Services\Web\Users;

use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AvatarsService
{
    protected $userModel;

    protected $categoryModel;

    public function __construct(User $userModel, Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;

        $this->userModel = $userModel;
    }

    public function add()
    {
        $categories = $this->categoryModel::with([
            'user',
            'postCategoris.post.user',
            'postCategoris.post.postComments',
            'postCategoris.post.postOpinion',
        ])->get();

        return (['categories' => $categories]);
    }
    public function create($createdData)
    {
        $avatarPath = $createdData['avatar']->store('avatars', 'public');

        $user = $this->userModel::find(auth('web')->id());

        if ($this->userModel::where(['id' => auth('web')->id()])->update(['avatar' => $avatarPath, 'updated_at' => $user->updated_at])) {
            return true;
        } else {
            return false;
        }
    }

    public function destroy()
    {
        $delete = DB::transaction(function () {

            $user = $this->userModel::find(auth('web')->id());

            $deleteInStorage = Storage::disk('public')->delete($user->avatar);

            $deletedUserAvatar = $this->userModel::where(['id' => auth('web')->id()])->update(['avatar' => Null, 'updated_at' => $user->updated_at]);

            if ($deletedUserAvatar === 1 && $deleteInStorage === true) {
                DB::commit();
                return true;
            }
        }, 3);
       
        if ($delete) {
            return true;
        } else {
            return false;
        };
    }
}
