<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('std_menus', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent');
            $table->string('name');
            $table->string('description');
            $table->string('link');
            $table->string('icon');
            $table->integer('order');
            $table->char('isactive',1)->default('y');
            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('std_menus');
    }
}
