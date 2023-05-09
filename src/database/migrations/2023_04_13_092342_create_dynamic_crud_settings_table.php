<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDynamicCrudSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dynamic_crud_settings', function (Blueprint $table) {
            $table->id();
            $table->string('form_name',50);
            $table->string('table_name',40);
            $table->text('model_name');
            //$table->text('model_name_location_sys')->nullable();
            $table->text('migration_path')->nullable();
            $table->text('migration_name')->nullable();
            $table->text('route_name')->unique();
            $table->string('middleware_name',30)->nullable();
            $table->text('style_custom')->nullable();
            $table->tinyInteger('has_timestamp')->default(1);
            $table->tinyInteger('has_softdelete')->default(1);
            $table->text('log');
            $table->json('table_cond')->nullable();
            $table->tinyInteger("migrate_status")->default(0)->comment("1=migrated,0=not migrate");
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
        Schema::dropIfExists('dynamic_crud_settings');
    }
}
