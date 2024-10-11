<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('click_limits', function (Blueprint $table) {
             $table->id();
            
             $table->foreignId('offer_id')->constrained('offers')->cascadeOnDelete();
              $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->integer('clicklimit');
            $table->timestamps();
             // Define a unique composite index
            $table->unique(['offer_id', 'student_id'], 'unique_offer_student');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('click_limits');
    }
};
