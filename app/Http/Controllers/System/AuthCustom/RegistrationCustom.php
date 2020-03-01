<?php

namespace App\Http\Controllers\System\AuthCustom;

use App\Http\Requests\Auth\RegistrationRequest;
use App\Library\InstallCms\Install;
use App\Models\Role;
use App\Models\SystemSettings;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationCustom extends Controller
{
    public function index()
    {
        return view('system.authCustom.registration');
    }

    public function registUser(RegistrationRequest $request)
    {
        Install::installRegistrationUser($request->except('_token'));

        Install::setDefaultContent();

        return redirect('/');
    }
}
