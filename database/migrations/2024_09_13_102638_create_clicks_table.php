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
        Schema::create('clicks', function (Blueprint $table) {
            $table->id();
            $table->string('offer_name');
            $table->foreignId('offer_id')->constrained('offers')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('advertiser_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('transaction_id')->unique();
            $table->text('user_agent');
            $table->string('device_type')->nullable();
            $table->string('device_name')->nullable();
            $table->string('os_name')->nullable();
            $table->string('os_version')->nullable();
            $table->string('browser_name')->nullable();
            $table->string('browser_version')->nullable();
            $table->string('ip_address');
            $table->string('country');
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('isp')->nullable();
            $table->string('http_refer')->nullable();
            $table->string('stu_sub')->nullable();
            $table->string('stu_sub2')->nullable();
            $table->string('stu_sub3')->nullable();
            $table->string('stu_sub4')->nullable();
            $table->string('stu_sub5')->nullable();
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
        Schema::dropIfExists('clicks');
    }
};
