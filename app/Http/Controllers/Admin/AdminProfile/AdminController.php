<?php

namespace App\Http\Controllers\Admin\AdminProfile;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserDataUpdateFormRequest;
use App\Http\Requests\UserPasswordUpdateFormRequest;
use App\Services\Admin\AdminProfile\AdminService;

class AdminController extends Controller
{
    protected $service;

    public function __construct(AdminService $service)
    {
        $this->service = $service;
    }

    //Admin Profile post
    public function adminProfile()
    {

        $data = $this->service->index();

        return view('Admin/AdminProfile.index', ['posts' => $data['posts'],  'regularUsers' => $data['regularUsers'], 'adminUsers' => $data['adminUsers']]);
    }


    public function adminDataUpdate(UserDataUpdateFormRequest $request)
    {
        $updatedData = $request->validated();

        $updated = $this->service->adminDataUpdate($updatedData);

        if ($updated) {
            return redirect()->back()->with(['changed' => 'your information has been changed.']);
        }
        return redirect()->back()->with(['notChange' => 'Your data has not changed.']);
    }

    public function adminPasswordUpdate(UserPasswordUpdateFormRequest $request)
    {
        $updatedPasswordData = $request->validated();

        $updated = $this->service->adminPasswordUpdate($updatedPasswordData);

        if ($updated) {
            return redirect()->back()->with(['passwordChanged' => 'your information has been changed.']);
        }
        return redirect()->back()->with(['passwordnotChange' => 'Your data has not changed.']);
    }
}
