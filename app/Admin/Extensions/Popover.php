<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/12/2
 * Time: 10:29
 */
namespace App\Admin\Extensions;

use Encore\Admin\Admin;
use Encore\Admin\Grid\Displayers\AbstractDisplayer;

class Popover extends AbstractDisplayer
{
    public function display($placement = 'left')
    {
        return 'Popover';
    }
}