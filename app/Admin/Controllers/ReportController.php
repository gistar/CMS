<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/27
 * Time: 8:54
 */

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use Encore\Admin\Widgets\Box;

class ReportController extends Controller
{
    public function index()
    {
        return Admin::content(function (Content $content) {
            return $content
                ->header('Chartjs')
                ->body(new Box('Bar chart', view('admin.chartjs')));
        });
    }
}