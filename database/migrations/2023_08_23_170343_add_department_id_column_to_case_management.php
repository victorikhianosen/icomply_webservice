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
        Schema::table('case_management', function (Blueprint $table) {
            $table->string('case_action')->nullable();
            $table->bigInteger('department_id')->nullable();
            $table->bigInteger('alert_id')->nullable();
            $table->bigInteger('process_id')->nullable();
            $table->foreign('process_id')
            ->references('id')->on('process')->onDelete('cascade');
            $table->foreign('department_id')
            ->references('id')->on('department')->onDelete('cascade');
            $table->foreign('alert_id')
            ->references('id')->on('alert')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('case_management', function (Blueprint $table) {
            //
        });
    }
};
