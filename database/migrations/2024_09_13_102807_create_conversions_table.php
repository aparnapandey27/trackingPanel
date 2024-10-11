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
        Schema::create('conversions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('offers')->cascadeOnDelete();
            $table->foreignId('affiliate_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('advertiser_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('click_transaction_id');
            $table->string('currency')->nullable();
            $table->decimal('revenue');
            $table->decimal('payout');
            $table->decimal('sale_amount', 10, 2)->nullable();
            $table->string('name')->default('default');
            $table->string('status', 20)->default('approved');
            $table->boolean('paid')->default(false);
            $table->string('conversion_ip')->nullable();
            $table->string('click_ip')->nullable();
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
        Schema::dropIfExists('conversions');
    }
};
