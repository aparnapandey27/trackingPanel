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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->string('currency')->default('USD');
            $table->decimal('default_revenue')->default(0);
            $table->integer('percent_revenue')->default(0);
            $table->decimal('default_payout')->default(0);
            $table->integer('percent_payout')->default(0);
            $table->string('conversion_tracking')->default('s2s');
            $table->string('offer_model')->default('CPA');
            $table->string('preview_url')->nullable();
            $table->string('tracking_url');
            $table->boolean('is_featured')->default(false);
            $table->string('conv_flow')->nullable();
            $table->boolean('same_ip_conversion')->default(false);
            $table->boolean('conversion_approval')->default(true);
            $table->integer('min_conversion_time')->default(1)->comment('in minutes');
            $table->integer('max_conversion_time')->default(30)->comment('in days');
            $table->string('offer_permission')->default('public');
            $table->integer('status')->default(0)->comment('0 = pending, 1 = active, 2 = close, 3 = expire');
            $table->foreignId('advertiser_id')->constrained('users')->cascadeOnDelete();
            $table->string('refer_rule')->default('302');
            $table->foreignId('redirect_offer_id')->nullable()->constrained('offers')->nullOnDelete();
            $table->timestamp('expire_at')->nullable();
            $table->text('note')->nullable();
            $table->string('thumbnail')->nullable();
            $table->foreignId('manager_id')->nullable()->constrained('users')->onDelete('set null');
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
        Schema::dropIfExists('offers');
    }
};
