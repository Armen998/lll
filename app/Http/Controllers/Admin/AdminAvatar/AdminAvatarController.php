<?php

namespace App\Http\Controllers\Admin\AdminAvatar;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarFormRequest;
use App\Services\Admin\AdminAvatar\AdminAvatarService;

class AdminAvatarController extends Controller
{
    protected $service;

    public function __construct(AdminAvatarService $service)
    {
        $this->service = $service;
    }

    //Add Avatar
    public function avatarAdd()
    {
        $data = $this->service->addAvatar();

        return view('Admin/AdminAvatar.avatar-add', ['user' => $data['user']]);
    }

    //Avatar Create
    public function avatarCreate(AvatarFormRequest $request)
    {
        $createdData = $request->validated();

        $update = $this->service->createAvatar($createdData);

        if ($update) {
            return redirect()->route('admin.home');
        }
        return redirect()->back();
    }

    //Delete Avatar
    public function avatarDestroy()
    {
        $delete = $this->service->avatarDestroy();
        if ($delete) {
            return redirect()->route('admin.users');
        }
        return redirect()->back();
    }
    
}
