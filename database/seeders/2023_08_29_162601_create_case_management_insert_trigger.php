<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::statement('
           CREATE OR REPLACE FUNCTION case_management_insert_trigger_function()
RETURNS TRIGGER AS $$
BEGIN
    DECLARE
        inserted_id INTEGER;
    BEGIN
        inserted_id := NEW.id;
        

        RETURN NEW;
    END;
$$ LANGUAGE plpgsql;



           
        ');
        DB::statement('CREATE TRIGGER case_management_trigger
AFTER INSERT ON case_management
FOR EACH ROW
EXECUTE FUNCTION case_management_trigger_function();');

       
    }

    /**
     * Run the migrations.
     *
     * @return void
     */

    public function down()
    {
         DB::statement('DROP FUNCTION IF EXISTS case_management_insert_trigger_function()');
         DB::statement('DROP TRIGGER IF EXISTS case_management_trigger ON case_management;');
    }
};
