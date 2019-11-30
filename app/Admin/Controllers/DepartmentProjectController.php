<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Project\Enterprise;
use App\Project;
use App\Department;

use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;

use Encore\Admin\Facades\Admin;
use Encore\Admin\Controllers\HasResourceActions;
use Illuminate\Http\Request;


class DepartmentProjectController extends Controller
{

    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\Project';

    protected function title()
    {
        return $this->title;
    }

    private function getTitle($departmentId)
    {
        $department = Department::find($departmentId);
        $this->title = $department->department_name . trans('admin.project');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($departmentId)
    {
        $grid = new Grid(new Project);
        $grid->column('project_id', __('Project id'));
        $grid->column('name', trans('admin.project_name'));
        $grid->column('department.department_name', trans('admin.department_name'));
        $grid->column('note', trans('admin.note'));

        $grid->column('createUser.name',  trans('admin.creater'));

        $grid->column('members', trans('admin.members'))->pluck('name')->label();

        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->model()->where('department_id', '=', $departmentId);

        //没有管理项目的权限
        if(Admin::user()->cannot('administrator.projects')){
            $project = Administrator::find(Admin::user()->id)->project()->get();
            $userProjectIds = $project->pluck('project_id')->all();
            $grid->actions(function ($actions) use ($userProjectIds){
                if(in_array($actions->getKey(), $userProjectIds)){
                    $actions->add(new Enterprise());
                }
            });
        }else{
            $grid->actions(function ($actions) {
                $actions->add(new Enterprise());
            });
        }

        $grid->model()->orderBy('project_id', 'desc');
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($departmentId, $projectId)
    {

        $show = new Show( Project::where('department_id' , '=', $departmentId)->findOrFail($projectId));

        $show->field('project_id', __('Project id'));
        $show->field('name', trans('admin.project_name'));

        $show->field('department', trans('admin.department_name'))->as(function ($departmentName){
            return $departmentName->department_name;
        });

        $show->field('note', trans('admin.Note'));

        $show->field('createUser', '项目创建人')->as(function ($createUser){
            return $createUser->name;
        });

        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($departmentId)
    {
        $form = new Form(new Project);
        $form->text('name', trans('admin.project_name'));

        //系统全部部门
        //$form->select('department_id', '部门')->options(Department::all()->pluck('department_name', 'department_id'));
        $form->hidden('department_id')->value($departmentId);

        //系统全部组员
        //$form->multipleSelect('members', '组员')->options(Administrator::all()->pluck('name','id'));
        //选择部门内部组员
        $form->multipleSelect('members', trans('admin.members'))->options(
                        Department::find($departmentId)
                            ->members()
                            ->pluck('name', 'id')
            );
        $form->text('note', trans('admin.note'));
        $form->hidden('create_user_id')->value(Admin::user()->id);
        /*$form->saving(function (Form $form){
            $form->create_user_id = Admin::user()->id;
        });*/
        return $form;
    }

    protected function index($departmentId, Content $content)
    {
        $this->getTitle($departmentId);
        return $content->title($this->title())
            ->description(trans('admin.list'))
            ->body($this->grid($departmentId));
    }

    protected function create($departmentId, Content $content)
    {
        $this->getTitle($departmentId);
        return $content->title($this->title())->body($this->form($departmentId));
    }

    protected function show($departmentId, $projectId, Content $content)
    {
        $this->getTitle($departmentId);
        return $content->title($this->title())->body($this->detail($departmentId, $projectId));
    }

    protected function edit($departmentId, $projectId, Content $content)
    {
        $this->getTitle($departmentId);
        return $content
            ->title($this->title())
            ->body($this->form($departmentId, $projectId)->edit($projectId));
    }

    protected function store($departmentId)
    {
        return $this->form($departmentId)->store();
    }

    public function update($departmentId, $projectId)
    {
        return $this->form($departmentId)->update($projectId);
    }

    public function destroy($departmentId, $projectId)
    {
        return $this->form($departmentId)->destroy($projectId);
    }
}
