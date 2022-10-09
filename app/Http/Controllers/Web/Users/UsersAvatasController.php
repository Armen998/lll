<?php

namespace App\Http\Controllers\Web\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\AvatarFormRequest;
use App\Models\User;
use App\Services\Web\Users\AvatarsService;

class UsersAvatasController extends Controller
{
    protected $service;
    
    protected $userModel;

    public function __construct(AvatarsService $service, User $userModel)
    {
        $this->service = $service;

        $this->userModel = $userModel;
    }

    //Add Avatar
    public function add()
    {
        $data = $this->service->add();

        return view('web/users.add', ['categories' => $data['categories']]);
    }

    public function create(AvatarFormRequest $request)
    {
        $createdData = $request->validated();

        $update = $this->service->create($createdData);

        if ($update) {
            return redirect()->route('home');
        }
        return redirect()->back();
    }

    //Delete Avatar
    public function destroy()
    {
        $delete = $this->service->destroy();
 
        if ($delete) {
            return redirect()->route('home');
        }
        return redirect()->back();
    }
}
