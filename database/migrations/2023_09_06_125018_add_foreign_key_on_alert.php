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
        Schema::table('alert', function (Blueprint $table) {
            $table->bigInteger('exception_process_status_id')->nullable();
            $table->bigInteger('exception_category_id')->nullable();
            $table->bigInteger('alert_group_id')->nullable();

            // $table->foreign('exception_process_status_id')
            // ->references('id')->on('exception_process_status')->onDelete('cascade');
            // $table->foreign('exception_category_id')
            // ->references('id')->on('exception_category')->onDelete('cascade');
            // $table->foreign('alert_group_id')
            // ->references('id')->on('alert_group_id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
