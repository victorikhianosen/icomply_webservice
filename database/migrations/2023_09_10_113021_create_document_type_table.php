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
        Schema::create('document_type', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->timestamp('created_at')->default(Carbon::now());
        });

        Schema::create('document', function (Blueprint $table) {
            $table->id();
            $table->string('filename');
            $table->bigInteger('user_id');
            $table->bigInteger('document_type_id');
            $table->string('name');
            $table->string('source_file');
            $table->string('description');
            $table->string('ref_no');
            $table->string('mime_type');
            $table->bigInteger('process_id');
            $table->bigInteger('first_owner_id');
            $table->bigInteger('second_owner_id');
            $table->bigInteger('alert_rule_id');
            $table->string('status');
            $table->bigInteger('approver_id');
            $table->date('approved_at');
            $table->timestamp('created_at')->default(Carbon::now());

            $table->foreign('process_id')
            ->references('id')->on('process')->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('document_type_id')
            ->references('id')->on('document_type')->onDelete('cascade');

            $table->foreign('first_owner_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('second_owner_id')
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
        Schema::dropIfExists('document_type');
        Schema::dropIfExists('document');

    }
};
