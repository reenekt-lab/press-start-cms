<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetAdditionalPropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('set_additional_properties', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('property_id')->unsigned();
            $table->foreign('property_id')->references('id')->on('list_additional_properties');

            $table->bigInteger('category_id')->unsigned();
            $table->foreign('category_id')->references('id')->on('categories');

            $table->string('name');
            $table->boolean('active');
            $table->string('user_symbol_code')->nullable();
            $table->string('defaultVal')->nullable();
            $table->string('width')->nullable();
            $table->string('height')->nullable();

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
        Schema::dropIfExists('set_additional_properties');
    }
}
