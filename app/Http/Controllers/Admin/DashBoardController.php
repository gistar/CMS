<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/16
 * Time: 9:02
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SysUser;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    protected function home(Request $request)
    {
        $userId = $request->session()->get('user_id');
        $userInfo = SysUser::query()->find($userId);
        return view('admin.dashboard');
    }
}