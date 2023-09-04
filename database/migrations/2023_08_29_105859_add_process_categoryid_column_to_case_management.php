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
            $table->jsonb('supervisor_id')->after('supervisor_name')->nullable();
            $table->bigInteger('process_categoryid')->nullable();
            $table->foreign('process_categoryid')
            ->references('id')->on('process_category')->onDelete('cascade');
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
