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
            // Drop the foreign key constraint

            // Rename the column
            $table->renameColumn('staff_responsible', 'assigned_user');
        });
    }

    public function down()
    {
        Schema::table('case_management', function (Blueprint $table) {
            // Recreate the foreign key constraint if needed
            $table->foreign('assigned_user')
                  ->references('id')->on('users')
                  ->onDelete('cascade');

            
        });
    }




};
