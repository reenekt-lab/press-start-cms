<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStorageValSetAdditionalPropsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('storage_val_set_additional_props', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->bigInteger('super_category_id')->unsigned();
            $table->foreign('super_category_id')->references('id')->on('categories');

            $table->bigInteger('content_id')->unsigned();
            $table->foreign('content_id')->references('id')->on('contents');

            $table->bigInteger('set_additional_prop_id')->unsigned();
            $table->foreign('set_additional_prop_id')->references('id')->on('set_additional_properties');

            $table->string('value')->nullable();

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
        Schema::dropIfExists('storage_val_set_additional_props');
    }
}
