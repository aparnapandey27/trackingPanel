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
        Schema::create('offer_students', function (Blueprint $table) {
            $table->id();
            
             $table->foreignId('offer_id')->constrained('offers')->cascadeOnDelete();
              $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('name');
            $table->string('pay_model')->default('CPA');
            $table->string('currency')->default('USD');
            $table->decimal('default_payout')->default(0);
            $table->integer('percent_payout')->default(0);
            $table->timestamps();
             // Define a unique composite index
            $table->unique(['offer_id', 'student_id', 'name'], 'unique_offer_student_name');
       
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offer_students');
    }
};
