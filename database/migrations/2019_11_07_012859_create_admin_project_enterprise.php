<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminProjectEnterprise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_project_enterprise', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',255)->nullable(false)->default('\"\"')->comment('公司名');
            $table->string('representative',50)->nullable(false)->default('\"\"')->comment('法人代表');
            $table->string('address',255)->nullable(false)->default('\"\"')->comment('公司地址');
            $table->string('region',50)->nullable(false)->default('\"\"')->comment('所属地区(省)');
            $table->string('city',50)->nullable(false)->default('\"\"')->comment('城市');
            $table->string('district',50)->nullable(false)->default('\"\"')->comment('区/县');
            $table->string('lat_long',80)->nullable(false)->default('\"\"')->comment('经纬度，json -> {"lat": "30.18484477830133", "long": "120.06383340659741"}');
            $table->string('biz_status',50)->nullable(false)->default('\"\"')->comment('经营状态');
            $table->string('credit_code',50)->nullable(false)->default('\"\"')->comment('统一社会信用代码');
            $table->string('register_code',50)->nullable(false)->default('\"\"')->comment('注册号');
            $table->string('phone',100)->nullable(false)->default('\"\"')->comment('电话');
            $table->string('email',100)->nullable(false)->default('\"\"')->comment('邮箱');
            $table->string('setup_time',20)->nullable(false)->default('\"\"')->comment('成立时间');
            $table->string('industry',50)->nullable(false)->default('\"\"')->comment('所属行业');
            $table->string('biz_scope',1200)->nullable(false)->default('\"\"')->comment('经营范围');
            $table->string('company_type',50)->nullable(false)->default('\"\"')->comment('公司类型');
            $table->string('registered_capital',50)->nullable(false)->default('\"\"')->comment('注册资本');
            $table->string('actual_capital',255)->nullable(false)->default('\"\"')->comment('实缴资本');
            $table->string('taxpayer_code',255)->nullable(false)->default('\"\"')->comment('纳税人识别号');
            $table->string('organization_code',255)->nullable(false)->default('\"\"')->comment('组织机构代码');
            $table->string('english_name',255)->nullable(false)->default('\"\"')->comment('公司英文名');
            $table->string('authorization',255)->nullable(false)->default('\"\"')->comment('登记机关');
            $table->string('homepage',522)->nullable(false)->default('\"\"')->comment('公司官网');
            $table->string('used_name',128)->nullable(false)->default('\"\"')->comment('公司曾用名');
            $table->string('score',32)->nullable(false)->default('\"\"')->comment('评分');
            $table->string('other',522)->nullable(false)->default('\"\"')->comment('其他');
            $table->string('word',200)->nullable(false)->default('\"\"')->comment('词源');
            $table->bigInteger('project_id')->unsigned()->default(0)->comment('项目id');
            $table->softDeletes()->useCurrent();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->index('project_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_project_enterprise');
    }
}
