<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/14
 * Time: 9:12
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SysUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:sys_user'],
            'phone' => ['required', 'digits:11'],
            'truename' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function registershow()
    {
        return view('admin.register');
    }

    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $sysUser = new SysUser();

        $sysUser->sys_uname = $request->name;
        $sysUser->pwd = $request->password;
        $sysUser->email = $request->email;
        $sysUser->tel = $request->phone;
        $sysUser->true_name = $request->truename;

        $res = $sysUser->save();

        dump($res);
    }

    protected function loginshow()
    {
        return view('admin.login');
    }

}