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
        Schema::table('process', function (Blueprint $table) {
            $table->text('mail_to')->nullable();
            $table->string('frequency')->nullable();
            $table->string('status')->nullable();
            $table->bigInteger('alert_group_id')->nullable();
            $table->string('branch_code')->nullable();
            $table->bigInteger('risk_rating_id')->nullable();
            $table->bigInteger('first_line_owner')->nullable();
            $table->bigInteger('second_line_owner')->nullable();
            $table->bigInteger('approver_id')->nullable();
            $table->date('approved_at')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->string('narration')->nullable();
            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('first_line_owner')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('second_line_owner')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('approver_id')
            ->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('process', function (Blueprint $table) {
            //
        });
    }
};
