<?php

namespace App\Admin\Controllers;

use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;

class HomeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('廊坊会议展览有限公司')
            ->description('CRM')
            //->row(Dashboard::title())
            ->row(function (Row $row) {

                $row->column(6, function (Column $column) {
                    $column->append(Dashboard::environment());
                });

                /*$row->column(4, function (Column $column) {
                    $column->append(Dashboard::extensions());
                });*/

                $row->column(6, function (Column $column) {
                    $column->append(Dashboard::dependencies());
                });
            });
    }
}
