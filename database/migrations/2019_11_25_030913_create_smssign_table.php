<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmssignTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('smssign', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->enum('SignSource',[0,1,2,3,4,5])->comment('0:企事业单位的全称或简称1:工信部备案网站的全称或简称2:APP应用的全称或简称3:公众号或小程序的全称或简称4:电商平台店铺名的全称或简称5:商标名的全称或简称');
            $table->string('Remark')->comment('短信签名申请说明');
            $table->enum('status',[0,1])->comment('0:未通过1:通过');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('smssign');
    }
}
