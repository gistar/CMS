<?php

namespace App\Admin\Controllers;

use App\Admin\Actions\Project\SelectEnterprise;
use App\Admin\Actions\Project\SendMessage;
use App\Http\Controllers\Controller;
use App\ProjectEnterpriseModel;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Facades\Admin;
use App\ProvinceModel;
use App\CityModel;
use App\CountryModel;
use App\Admin\Actions\Project\ExportTemplate;
use App\Admin\Actions\Project\ImportEnterprise;

use App\Project;

class ProjectEnterpriseController extends Controller
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\ProjectEnterpriseModel';

    protected function title()
    {
        return $this->title;
    }

    private function getTitle($projectId)
    {
        $project = Project::find($projectId);
        $this->title = $project->name . trans('admin.projectEnterprise');
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid($projectId)
    {
        $grid = new Grid(new ProjectEnterpriseModel);
        $grid->tools(function (Grid\Tools $tools){
            $tools->append(new ExportTemplate());
        });
        $grid->tools(function (Grid\Tools $tools){
            $tools->append(new ImportEnterprise());
        });

        $grid->batchActions(function ($batch){
            $batch->add(new SendMessage());
        });
        /*$grid->tools(function (Grid\Tools $tools){
            $tools->append(new SelectEnterprise());
        });*/
        $grid->expandFilter();

        $grid->filter(function ($filter) use ($projectId){

            $filter->expand();
            $filter->disableIdFilter();
            $filter->column(1/2,function ($filter) use ($projectId){
                $filter->like('name','公司名称');
                $filter->like('representative','法人代表');

                $projectEnterpriseModel = new ProjectEnterpriseModel();
                //$orders = $projectEnterpriseModel->where('project_id', $projectId)->get();
                $ordersBatch = ProjectEnterpriseModel::with('order')->where('project_id',$projectId)->get();

                $orderMembers = array();
                foreach ($ordersBatch as $order)
                {
                    if(isset($order->order->id)){
                        $orderMembers[$order->order->id] = $order->order->name ? $order->order->name  : '';
                    }
                }
                $filter->equal('order_user_id', '成单人')->select($orderMembers);
                $filter->like('phone','电话');
                $lasterBatch = ProjectEnterpriseModel::with('lasterEditer')->where('project_id', $projectId)->get();
                $lasterMembers = array();
                foreach ($lasterBatch as $lasterEditor)
                {
                    if(isset($lasterEditor->lasterEditer->id)){
                        $lasterMembers[$lasterEditor->lasterEditer->id] = $lasterEditor->lasterEditer->name;
                    }
                }
                $filter->equal('lasteditor_id', '最后编辑人')->select($lasterMembers);
            });

            $filter->column(1/2,function ($filter) use ($projectId) {
                $filter->equal('region','省')->select(ProvinceModel::all()->pluck('name','name'))->load('city', '/api/city');
                $filter->equal('city','市')->select('/api/city')->load('district', '/api/country');
                $filter->like('email','Email');
                //$filter->equal('district','区县')->select('/api/country');
                $createrBatch = ProjectEnterpriseModel::with('creater')->where('project_id', $projectId)->get();
                $createrMembers = array();
                foreach ($createrBatch as $creater)
                {
                    if(isset($creater->creater->id)){
                        $createrMembers[$creater->creater->id] = $creater->creater->name;
                    }
                }
                $filter->equal('create_user_id', '创建人')->select($createrMembers);
                $filter->between('created_at', '创建时间')->datetime();
            });
        });
        $grid->column('id', trans('Id'));
        $grid->column('name', trans('admin.companyName'));
        $grid->column('representative', trans('admin.representative'));
        $grid->column('address', trans('admin.address'));
        $grid->column('region', trans('admin.region'));
        $grid->column('city', trans('admin.city'));
        $grid->column('district', trans('admin.district'));
        //$grid->column('lat_long', trans('admin.lat long'));
        $grid->column('biz_status', trans('admin.bizStatus'));
        $grid->column('credit_code', trans('admin.creditCode'));
        $grid->column('register_code', trans('admin.registerCode'));

        $grid->column('phone', trans('admin.phone'))->display(function ($phone){
            return mb_substr($phone, 0, 20) . '...';
        });

        $grid->column('email', trans('admin.email'))->display(function ($email){
            return mb_substr($email, 0, 20) . '...';
        });


        $grid->column('setup_time', trans('admin.setupTime'));
        //$grid->column('industry', trans('admin.industry'));

        //$grid->column('company_type', trans('admin.companyType'));
        //$grid->column('registered_capital', trans('admin.registeredCapital'));
        //$grid->column('actual_capital', trans('admin.actualCapital'));
        //$grid->column('taxpayer_code', trans('admin.taxpayerCode'));
        //$grid->column('organization_code', trans('admin.organizationCode'));
        //$grid->column('english_name', trans('admin.englishName'));
        //$grid->column('authorization', trans('admin.authorization'));
        //$grid->column('homepage', trans('admin.homepage'));
        //$grid->column('used_name', trans('admin.usedName'));
        //$grid->column('score', trans('admin.score'));
        //$grid->column('other', trans('admin.other'));
        $grid->column('word', trans('admin.word'));

        $grid->column('creater.name', trans('admin.creater'));
        $grid->column('note', trans('admin.note'))->display(function($note){
            if(!empty($note) && mb_strlen($note) > 20){
                return mb_substr($note, 0, 20) . '...';
            }
            return $note;
        });
        $grid->column('order.name', trans('admin.orderMember'));
        $grid->column('contract_fund', trans('admin.contractFund'));

        //$grid->column('project.name', trans('admin.project'));
        $statusArray = ['0' => '未跟踪',
                    '1' => '跟踪进行时',
                    '2' => '意向客户',
                    '3' => '非意向客户',
                    '4' => '已成交用户'];
        $grid->column('status', trans('admin.status'))->display(function($status) use ($statusArray){
            return $statusArray[$status];
        });
        $grid->column('created_at', trans('admin.Created at'));
        $grid->column('updated_at', trans('admin.Updated at'));

        //$grid->model()->where('project_id', '=', $projectId)->searchable();
        $grid->model()->where('project_id', '=', $projectId);
        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(ProjectEnterpriseModel::findOrFail($id));

        $show->field('id', trans('admin.Id'));
        $show->field('name', trans('admin.companyName'));
        $show->field('representative', trans('admin.representative'));
        $show->field('address', trans('admin.address'));
        $show->field('region', trans('admin.region'));
        $show->field('city', trans('admin.city'));
        $show->field('district', trans('admin.district'));
        $show->field('lat_long', trans('admin.latLong'));
        $show->field('biz_status', trans('admin.bizStatus'));
        $show->field('credit_code', trans('admin.creditCode'));
        $show->field('register_code', trans('admin.registerCode'));
        $show->field('phone', trans('admin.phone'));
        $show->field('email', trans('admin.email'));
        $show->field('setup_time', trans('admin.setupTime'));
        /*$show->field('industry', trans('admin.industry'));
        $show->field('biz_scope', trans('admin.bizScope'));
        $show->field('company_type', trans('admin.companyType'));
        $show->field('registered_capital', trans('admin.registeredCapital'));
        $show->field('actual_capital', trans('admin.actualCapital'));
        $show->field('taxpayer_code', trans('admin.taxpayerCode'));
        $show->field('organization_code', trans('admin.organizationCode'));
        $show->field('english_name', trans('admin.englishName'));
        $show->field('authorization', trans('admin.authorization'));
        $show->field('homepage', trans('admin.homepage'));
        $show->field('used_name', trans('admin.usedName'));
        $show->field('score', trans('admin.score'));
        $show->field('other', trans('admin.other'));*/
        $show->field('word', trans('admin.word'));

        $show->field('creater', trans('admin.creater'))->as(function ($creater){
            return $creater->name;
        });
        $show->field('note', trans('admin.note'));
        $show->field('orderMember', trans('admin.orderMember'));

        $show->field('project_id', trans('admin.project'));
        $show->field('deleted_at', trans('admin.Deleted at'));
        $show->field('created_at', trans('admin.Created at'));
        $show->field('updated_at', trans('admin.Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form($projectId)
    {
        $form = new Form(new ProjectEnterpriseModel);
        $form->column(1/2, function ($form){
            $form->text('name', trans('admin.companyName'));
            $form->text('representative', trans('admin.representative'));
            $form->text('address', trans('admin.address'));

            $form->select('region', '省')->options(ProvinceModel::all()->pluck('name','name'))->load('city','/api/city');

            $form->select('city', '市')->options(function($city){
                if($city){
                    $cityid = CityModel::where('name', $city)->first()->city_id;
                    return CityModel::where('province_id' , CityModel::where('city_id', $cityid)->first()->province_id)->pluck('name', 'name');
                }
            })->load('district', '/api/country');

            $form->select('district', '区县')->options(function($country){
                if($country){
                    $countryid = CountryModel::where('name', $country)->first()->country_id;
                    return CountryModel::where('city_id', CountryModel::where('country_id', $countryid)->first()->city_id)->pluck('name', 'name');
                }
            });
            $form->select('biz_status', trans('admin.bizStatus'))->options([
                '在业' => '在业',
                '存续' => '存续',
                '吊销，未注销' => '吊销，未注销',
                '注销' => '注销',
                '迁出' => '迁出',
                '其他' =>'其他']);
            $form->text('credit_code', trans('admin.creditCode'));
            $form->text('register_code', trans('admin.registerCode'));
        });

        $form->column(1/2,function ($form) use ($projectId){
            //$form->text('lat_long', trans('admin.latLong'));

            $form->mobile('phone', trans('admin.phone'));
            $form->email('email', trans('admin.email'));
            $form->date('setup_time', trans('admin.setupTime'));
            $form->select('status', '状态')->options(['0' => '未跟踪',
                '1' => '跟踪进行时',
                '2' => '意向客户',
                '3' => '非意向客户',
                '4' => '已成交用户']);
            $form->decimal('contract_fund','合同金额');
            $form->text('word', trans('admin.word'));
            $form->hidden('project_id')->value($projectId);

            $form->hidden('create_user_id')->value(Admin::user()->id);
            $form->textarea('note', '备注')->rows(5);
        });

        /*$form->text('industry', trans('admin.industry'));
        $form->text('biz_scope', trans('admin.bizScope'));
        $form->text('company_type', trans('admin.companyType'));
        $form->text('registered_capital', trans('admin.registeredCapital'));
        $form->text('actual_capital', trans('admin.actualCapital'));
        $form->text('taxpayer_code', trans('admin.taxpayerCode'));
        $form->text('organization_code', trans('admin.organizationCode'));
        $form->text('english_name', trans('admin.englishName'));
        $form->text('authorization', trans('admin.authorization'));
        $form->text('homepage', trans('admin.homepage'));
        $form->text('used_name', trans('admin.usedName'));
        $form->text('score', trans('admin.score'));
        $form->text('other', trans('admin.other'));*/

        $form->saving(function (Form $form){
            if($form->status == 4){
                $form->order_user_id = Admin::user()->id;
            }
        });
        return $form;
    }

    protected function index($projectId, Content $content)
    {
        $this->getTitle($projectId);
        return $content->title($this->title())
            ->description(trans('admin.list'))
            ->body($this->grid($projectId));
    }

    protected function create($projectId, Content $content)
    {
        $this->getTitle($projectId);
        return $content->title($this->title())->body($this->form($projectId));
    }

    protected function show($id, Content $content)
    {
        return $content->title($this->title())->body($this->detail($id));
    }

    protected function edit($projectId, $enterpriseId, Content $content)
    {
        return $content
            ->title($this->title($projectId))
            ->body($this->form($projectId)->edit($enterpriseId));
    }

    protected function selectEnterprise($projectId, Content $content)
    {

        $form = new \Encore\Admin\Widgets\Form();
        $form->action('send');
        $form->text('title','标题')->rules('required');
        $form->textarea('content','内容')->rules('required');

        $content->body($form);
        $js = <<<SCRIPT
        
SCRIPT;
        Admin::script($js);
        return $content;
    }

    protected function store($objectId)
    {
        return $this->form($objectId)->store();
    }

    public function update($objectId, $enterpriseId)
    {
        return $this->form($objectId)->update($enterpriseId);
    }

    public function destroy($objectId, $enterpriseId)
    {
        return $this->form($objectId)->destroy($enterpriseId);
    }
}
