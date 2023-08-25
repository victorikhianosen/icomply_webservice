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
        Schema::create('alert', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('alert_action');
            $table->bigInteger('case_status_id');
            $table->bigInteger('department_id');
            $table->bigInteger('process_id');
            $table->bigInteger('user_id');
            $table->foreign('case_status_id')
            ->references('id')->on('case_status')->onDelete('cascade');
            $table->foreign('department_id')
            ->references('id')->on('department')->onDelete('cascade');
            $table->foreign('process_id')
            ->references('id')->on('process')->onDelete('cascade');
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->timestamp('created_at')->default(Carbon::now());
            $table->timestamp('updated_at')->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alert');
    }
};
