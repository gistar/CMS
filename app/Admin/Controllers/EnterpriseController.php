<?php

namespace App\Admin\Controllers;


use App\Admin\Actions\Enterprise\ImportPost;
use App\Admin\Actions\Post\ExportPost;
use App\EnterpriseModel;
use App\Imports\EnterpriseImport;
use App\ProvinceModel;
use App\CityModel;
use App\CountryModel;
use Encore\Admin\Grid;
use Encore\Admin\Form;
use Encore\Admin\show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Controllers\HasResourceActions;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Admin\Actions\Enterprise\BatchSelectProject;

class EnterpriseController extends Controller
{

    use HasResourceActions;

    protected $title = '公司';

    protected function title()
    {
        return $this->title;
    }

    protected function grid()
    {
        $grid = new Grid(new enterpriseModel());
        $grid->batchActions(function ($batch){
            $batch->add(new BatchSelectProject());
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new ImportPost());
        });
        $grid->tools(function (Grid\Tools $tools) {
            $tools->append(new ExportPost());
        });
        $grid->column('id', 'ID')->sortable();

        $grid->column('name', '公司名称');

        $grid->column('representative', '法人/经营者');

        $grid->column('region','省');

        $grid->column('city', '市');

        $grid->column('district', '区/县');

        $grid->column('setup_time', '成立时间');

        $grid->column('registered_capital', '注册资本');

        $grid->column('biz_status', '状态');

        $grid->column('phone', '电话');

        $grid->column('email', 'Email');

        $grid->column('word', '词源');
        $grid->expandFilter();
        $grid->filter(function ($filter){

            $filter->expand();
            $filter->disableIdFilter();
            $filter->column(1/2,function ($filter){
                $filter->like('name','公司名称');
                $filter->like('representative','法人代表');
                $filter->like('phone','电话');
                $filter->between('gmt_create', '创建时间')->datetime();
            });

            $filter->column(1/2,function ($filter){
                $filter->equal('region','省')->select(ProvinceModel::all()->pluck('name','name'))->load('city', '/api/city');
                $filter->equal('city','市')->select('/api/city')->load('district', '/api/country');
                //$filter->equal('district','区县')->select('/api/country');
                $filter->like('email','Email');
                $filter->equal('word','词源');
            });
        });
        return $grid;
    }

    protected function detail($id)
    {
        $show = new Show(enterpriseModel::findOrFail($id));

        $show->field('id', 'Id');
        $show->field('name', '公司名称');
        $show->field('representative', '法人代表');
        $show->field('region', '省');
        $show->field('city', '市');
        $show->field('district', '区县');
        $show->field('phone', '电话');
        $show->field('email', '邮箱');
        $show->field('setup_time', '成立时间');
        $show->field('registered_capital', '注册资本');
        $show->field('gmt_create', '创建时间');
        $show->field('gmt_modify', '修改时间');

        return $show;
    }

    protected function form()
    {
        $form = new Form(new enterpriseModel());

        $form->text('name', '企业名称')->rules('required|min:3');

        $form->text('representative', '企业法人')->rules('required|min:3');

        $form->select('region', '省')->options(ProvinceModel::all()->pluck('name','name'))->load('city','/api/city');

        $form->select('city', '市')->options(function($city){
            if($city){
                $cityid = CityModel::where('name', $city)->first()->city_id;
                //dd(CityModel::where('province_id' , CityModel::where('city_id', $cityid)->first()->province_id)->pluck('name', 'name'));
                return CityModel::where('province_id' , CityModel::where('city_id', $cityid)->first()->province_id)->pluck('name', 'name');
            }
        })->load('district', '/api/country');

        $form->select('district', '区县')->options(function($country){
            if($country){
                $countryid = CountryModel::where('name', $country)->first()->country_id;
                return CountryModel::where('city_id', CountryModel::where('country_id', $countryid)->first()->city_id)->pluck('name', 'name');
            }
        });
//        $form->select('city', '市')->options(function($id){
//            if($id){
//                return CityModel::where('province_id' , CityModel::where('city_id', $id)->first()->province_id)->pluck('name', 'city_id');
//            }
//            return CityModel::where('city_id', $id)->pluck('name', 'city_id');
//        })->load('district', '/api/country');

//        $form->select('region', '省')->options(ProvinceModel::all()->pluck('name','province_id'))->load('city','/api/city');
//        $form->select('city', '市')->options(function($id){
//            if($id){
//                return CityModel::where('province_id' , CityModel::where('city_id', $id)->first()->province_id)->pluck('name', 'city_id');
//            }
//            return CityModel::where('city_id', $id)->pluck('name', 'city_id');
//        })->load('district', '/api/country');
//
//        $form->select('district', '区县')->options(function($id){
//            if($id){
//                return CountryModel::where('city_id', CountryModel::where('country_id', $id)->first()->city_id)->pluck('name', 'country_id');
//            }
//            return CountryModel::where('country_id', $id)->pluck('name', 'country_id');
//        });

        $form->select('biz_status', '公司状态')->options(['存续' =>'存续','在业' => '在业','吊销，未注销' => '吊销，未注销','注销' => '注销','迁出' => '迁出']);

        $form->text('phone', '联系电话');

        $form->text('email', 'Email');

        $form->date('setup_time', '成立日期');

        $form->text('registered_capital', '注册资本');

        $form->text('word', '词源');

        return $form;
    }

    protected function index(Content $content)
    {
        return $content->title($this->title())->description('列表')->body($this->grid());
    }

    protected function create(Content $content)
    {
        return $content->title($this->title())->body($this->form());
    }

    protected function show($id, Content $content)
    {
        return $content->title($this->title())->body($this->detail($id));
    }

    protected function edit($id, Content $content)
    {
        return $content->title($this->title())->body($this->form()->edit($id));
    }
}