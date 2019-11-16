<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmaillogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emaillog', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email');
            $table->unsignedInteger('templateid');
            $table->enum('status', ['presend', 'sending', 'sended', 'sendwar']);
            $table->unsignedMediumInteger('service');
            $table->unsignedInteger('sender');
            $table->string('message');
            $table->enum('openstatus', ['unknow', 'received', 'unopened', 'opened']);
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
        Schema::dropIfExists('emaillog');
    }
}
