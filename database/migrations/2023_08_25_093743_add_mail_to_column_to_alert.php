<?php

use Doctrine\DBAL\Types\Type;
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
        // Schema::table('alert', function (Blueprint $table) {
        //     $table->array('mail_to');
            
        // });
        Schema::table('alert', function (Blueprint $table) {
            $table->jsonb('mail_to');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('alert', function (Blueprint $table) {
            $table->dropColumn('mail_to');
        });
    }
};
