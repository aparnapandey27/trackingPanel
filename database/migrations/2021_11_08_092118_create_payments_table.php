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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users')->cascadeOnDelete();
            $table->string('period')->nullable();
            $table->decimal('amount', 10, 2)->default(0.00);
            $table->decimal('adjustment')->default(0.00);
            $table->decimal('payable_amount');
            $table->string('currency')->default('USD');
            $table->integer('status')->default(0);
            $table->string('note')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('payment_method_detail')->nullable();
            $table->string('payment_frequency')->default('monthly');
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
        Schema::dropIfExists('payments');
    }
};
