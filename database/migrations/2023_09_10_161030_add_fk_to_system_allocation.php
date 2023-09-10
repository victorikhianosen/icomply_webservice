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
        Schema::table('system_allocation', function (Blueprint $table) {
            $table->foreign('approver_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('responsible_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('system_id')
            ->references('id')->on('system')->onDelete('cascade');
        });

        Schema::table('system', function (Blueprint $table) {
            $table->foreign('approver_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('owner_1')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('owner_2')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('process_id')
                ->references('id')->on('process')->onDelete('cascade');

            $table->foreign('process_category')
            ->references('id')->on('process_category')->onDelete('cascade');

            $table->foreign('category_id')
            ->references('id')->on('system_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('system_allocation', function (Blueprint $table) {
            //
        });
    }
};
