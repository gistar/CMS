<?php

namespace App\Admin\Actions\Enterprise;

use App\ProjectEnterpriseModel;
use App\ProjectMembers;
use Encore\Admin\Actions\BatchAction;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Collection;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BatchSelectProject extends BatchAction
{
    public $name = '选择需要加入的项目';

    public function handle(Collection $collection, Request $request)
    {
        $project_id = $request->project_id;
        $createId = Admin::user()->id;

        $importData = array();
        $checkBoxIds = array();
        foreach ($collection as $model) {
            $checkBoxIds[] = $model->id;
            $importData[] = array(
                'name' => $model->name,
                'representative' => $model->representative,
                'region' => $model->region,
                'city' => $model->city,
                'district' => $model->district,
                'biz_status' => $model->biz_status,
                'phone' => $model->phone,
                'email' => $model->email,
                'setup_time' => $model->setup_time,
                'registered_capital' => $model->registered_capital,
                'word' => $model->word,
                'create_user_id' => $createId,
                'project_id' => $project_id,
                'source_id' => $model->id
            );
        }
        $existArray = ProjectEnterpriseModel::query()->whereIn('source_id', $checkBoxIds)->where('project_id',$project_id)->pluck('name');
        if(empty($existArray)){
            if(!empty($importData))
            {
                DB::table('admin_project_enterprise')->insert($importData);
            }
            return $this->response()->success('成功导入项目')->refresh();
        }else{
            foreach ($existArray as $enterprise){
                $enterprises[] = $enterprise;
            }
            $warinfo = implode('<br/>', $enterprises) . '<br/>已经在该项目中';

            return $this->response()->warning($warinfo)->timeout(5000)->refresh();
        }

    }

    public function form()
    {
        $membersModel = new Administrator();
        $user = $membersModel->find(Admin::user()->id);
        $projects = array();
        foreach ($user->projectMember as $project)
        {
            $projects[$project->project_id] = $project->name;
        }
        $this->select('project_id', '项目')->options($projects);
    }
}