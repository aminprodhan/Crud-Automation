<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicCrudFormDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_crud_form_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dynamic_crud_settings_id');
            $table->integer('sort_id')->default(100);
            $table->string('label_name',255);
            $table->string('field_name',100);
            $table->string('input_type',20);
            $table->json('event_actions')->nullable();
            $table->tinyInteger('display_type');
            $table->tinyInteger('options_data_type')->default(1)->comment("1=static data,2=select query");
            $table->text('options')->nullable();
            $table->text('validation')->nullable();
            $table->json("db_info")->nullable();
            $table->string('session_name_func',100)->nullable();
            $table->string('relation_name',255)->nullable();
            $table->tinyInteger("status")->default(1)->comment("1=active,2=inactive");
            $table->tinyInteger("filterable")->default(0);
            $table->index('dynamic_crud_settings_id','dynamic_crud_settings_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dynamic_crud_form_details');
    }
}
