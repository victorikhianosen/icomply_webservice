<?php

use Carbon\Carbon;
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
        Schema::create('system_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('category_id')->nullable();
            $table->timestamp('created_at')->default(Carbon::now());
        });

        Schema::create('system', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('owner_1')->nullable();
            $table->bigInteger('owner_2')->nullable();
            $table->string('model_number')->nullable();
            $table->bigInteger('approver_id')->nullable();
            $table->bigInteger('process_category')->nullable();
            $table->bigInteger('process_id')->nullable();
            $table->string('additional_comment')->nullable();
            $table->date('approved_at')->nullable();
            $table->string('ref_no')->nullable();
            $table->bigInteger('category_id')->nullable();

            $table->timestamp('created_at')->default(Carbon::now());
        });

        Schema::create('system_allocation', function (Blueprint $table) {
            $table->id();
            $table->string('reference_no')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('system_id')->nullable();
            $table->date('approved_at')->nullable();
            $table->string('description')->nullable();
            $table->bigInteger('responsible_id')->nullable();
            $table->bigInteger('approver_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('category_id')->nullable();
            $table->timestamp('created_at')->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_category');
        Schema::dropIfExists('system');
        Schema::dropIfExists('system_allocation');

    }
};
