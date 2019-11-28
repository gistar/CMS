<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/11/27
 * Time: 8:54
 */

namespace App\Admin\Controllers;

use Carbon\CarbonImmutable;

use Encore\Admin\Auth\Database\Administrator;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Widgets\Box;
use Encore\Admin\Widgets\Table;
use Illuminate\Support\Facades\DB;


class ReportController extends Controller
{
    private $ch;

    public function __construct()
    {
        $this->ch = CarbonImmutable::now()->locale('zh');
    }

    //上周
    public function lastweek(Content $content)
    {
        $lastWeekStart = $this->ch->subWeek()->startOfWeek()->format('Y-m-d H:i');
        $lastWeekEnd = $this->ch->subWeek()->endOfWeek()->format('Y-m-d H:i');
        //上周
        $weekRaw = $this->getDatasDuringTime($lastWeekStart, $lastWeekEnd);
        $users = Administrator::all();
        foreach ($users as $user)
        {
            //上周
            $user->setAttribute('lastWeek', $this->getUserStatus($weekRaw, $user));
        }
        $rows = $this->getCurrTable($users, 'lastWeek');
        $table = new Table(['Id', 'Name', '总共', '未跟踪', '跟踪中', '有意向', '没意向', '成交'], $rows);

        $content->row(function (Row $row) use ($table, $rows){
            $row->column(8, new Box('昨天', view('admin.chartjs', [ 'rows' => $rows])));
            $row->column(4, $table->render());
        });
        return $content;
    }

    //当月
    public function currmonth(Content $content)
    {
        $monthStart = $this->ch->startOfMonth()->format('Y-m-d H:i');
        $monthEnd = $this->ch->endOfMonth()->format('Y-m-d H:i');

        $currMonthRaw = $this->getDatasDuringTime($monthStart, $monthEnd);
        $users = Administrator::all();
        foreach ($users as $user)
        {
            $user->setAttribute('currMonth', $this->getUserStatus($currMonthRaw, $user));
        }
        $rows = $this->getCurrTable($users, 'currMonth');
        $table = new Table(['Id', 'Name', '总共', '未跟踪', '跟踪中', '有意向', '没意向', '成交'], $rows);

        $content->row(function (Row $row) use ($table, $rows){
            $row->column(8, new Box('昨天', view('admin.chartjs', [ 'rows' => $rows])));
            $row->column(4, $table->render());
        });
        return $content;
    }

    //上个月
    public function lastmonth(Content $content)
    {

        $lastMonthStart = $this->ch->subMonth()->startOfMonth()->format('Y-m-d H:i');
        $lastMonthEnd = $this->ch->subMonth()->endOfMonth()->format('Y-m-d H:i');

        $lastMonthRaw = $this->getDatasDuringTime($lastMonthStart, $lastMonthEnd);
        $users = Administrator::all();
        foreach ($users as $user)
        {
            $user->setAttribute('lastMonth', $this->getUserStatus($lastMonthRaw, $user));
        }

        $rows = $this->getCurrTable($users, 'lastMonth');
        $table = new Table(['Id', 'Name', '总共', '未跟踪', '跟踪中', '有意向', '没意向', '成交'], $rows);

        $content->row(function (Row $row) use ($table, $rows){
            $row->column(8, new Box('昨天', view('admin.chartjs', [ 'rows' => $rows])));
            $row->column(4, $table->render());
        });
        return $content;
    }

    //昨天
    public function index(Content $content)
    {
        //昨天
        $lastDayStart = $this->ch->subDay()->startOfDay()->format('Y-m-d H:i');
        $lastDayEnd = $this->ch->subDay()->endOfDay()->format('Y-m-d H:i');

        $users = Administrator::all();
        //昨天
        $yesRow = $this->getDatasDuringTime($lastDayStart, $lastDayEnd);

        foreach ($users as $user)
        {
            $user->setAttribute('yesterday', $this->getUserStatus($yesRow, $user));
        }

        $rows = $this->getCurrTable($users, 'yesterday');
        $table = new Table(['Id', 'Name', '总共', '未跟踪', '跟踪中', '有意向', '没意向', '成交'], $rows);

        $content->row(function (Row $row) use ($table, $rows){
            $row->column(8, new Box('昨天', view('admin.chartjs', [ 'rows' => $rows])));
            $row->column(4, $table->render());
        });
        return $content;
    }

    /**
     * @param $start
     * @param $end
     *
     */
    private function getDatasDuringTime($start, $end)
    {
        $result = DB::table('admin_project_enterprise')
            ->select(DB::raw('create_user_id, status, COUNT(*) as num'))
            ->groupBy('create_user_id','status')
            ->whereBetween('created_at', [$start, $end])
            ->get();
        $data = [];
        foreach ($result as $item)
        {
            $data[$item->create_user_id][$item->status] = $item->num;
        }
        return $data;
    }

    /**
     * @param $dataRaw
     * @param $user
     * @return array
     */
    private function getUserStatus($dataRaw, $user)
    {
        $untrack = isset($dataRaw[$user->id][0]) ? $dataRaw[$user->id][0] : 0;
        $tracking = isset($dataRaw[$user->id][1]) ? $dataRaw[$user->id][1] : 0;
        $want = isset($dataRaw[$user->id][2])? $dataRaw[$user->id][2] : 0;
        $unwant = isset($dataRaw[$user->id][3]) ? $dataRaw[$user->id][3] : 0;
        $deal = isset($dataRaw[$user->id][4]) ? $dataRaw[$user->id][4] : 0;

        $statusArr = array('untrack' => $untrack,
                    'tracking' => $tracking,
                    'want' => $want,
                    'unwant' => $unwant,
                    'deal' => $deal);
        return $statusArr;
    }

    private function getCurrTable($users, $during)
    {
        $rows = [];
        foreach($users as $item){
            $rows[] = [
                0 => $item->id,
                1 => $item->username,
                2 => array_sum($item->$during),
                3 => $item->$during['untrack'],
                4 => $item->$during['tracking'],
                5 => $item->$during['want'],
                6 => $item->$during['unwant'],
                7 => $item->$during['deal']
            ];
        }
        return $rows;
    }
}