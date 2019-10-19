<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SysUser;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    protected $redirectTo = 'admin/dashBoard';

    public function __construct()
    {

    }

    protected function validator(array $data)
    {
        return Validator::make($data,[
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8']
        ]);
    }

    protected function loginshow(Request $request)
    {
        if($request->session()->exists('user_id')){
            return redirect()->route('dashBoard');
        }
        return view('admin.login');
    }

    protected function login(Request $request)
    {
        $this->validator($request->all())->validate();

        $sysUser = new SysUser();
        $result = $sysUser::where([
            ['sys_uname',$request->name],
            ['pwd', $request->password]
        ])->first();
        if($result){
            //$request->session()->put('user_id', $result->sys_uid);
            session(['user_id' => $result->sys_uid]);
            Session::save();
            return redirect()->route('dashBoard');
        }
        return redirect()->route('login');
    }
}
