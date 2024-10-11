<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMenuTable extends Migration
{
    public function up()
    {
        Schema::create('sidebar_menu', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('url')->nullable(); 
            $table->integer('parent_id')->nullable(); 
            $table->integer('order_no'); 
            $table->string('role'); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('menu');
    }
}
