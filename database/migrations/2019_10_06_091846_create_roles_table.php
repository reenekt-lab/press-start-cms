<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->boolean('super_user');

            $table->boolean('access_admin_page');
            $table->boolean('access_content');
            $table->boolean('access_security');
            $table->boolean('access_setting');
            $table->boolean('access_to_create');
            $table->boolean('access_to_edit');
            $table->boolean('access_to_delete');

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
        Schema::dropIfExists('roles');
    }
}
