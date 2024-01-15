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
        Schema::create('stmt_entry', function (Blueprint $table) {
            $table->id();
            $table->string('account_number')->nullable();
            $table->string('country_code')->nullable();
            $table->string('amt_lcy')->nullable();
            $table->string('transaction_code')->nullable();
            $table->string('their_reference')->nullable();
            $table->string('narrative')->nullable();
            $table->string('pl_category')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->bigInteger('account_officer')->nullable();
            $table->bigInteger('product_category')->nullable();
            $table->date('value_date')->nullable();
            $table->string('currency')->nullable();
            $table->string('amount_fcy')->nullable();
            $table->string('exchange_rate')->nullable();
            $table->string('negotiated_ref_num')->nullable();
            $table->string('position_type')->nullable();
            $table->string('our_reference')->nullable();
            $table->string('reversal_maker')->nullable();
            $table->date('exposure_date')->nullable();
            $table->string('currency_marker')->nullable();
            $table->string('department_code')->nullable();
            $table->string('trans_reference')->nullable();
            $table->bigInteger('system_id')->nullable();
            $table->date('booking_date')->nullable();
            $table->string('stmt_no')->nullable();
            $table->string('override')->nullable();
            $table->string('record_status')->nullable();
            $table->string('curr_no')->nullable();
            $table->string('inputter')->nullable();
            $table->timestamp('created_at')->default(Carbon::now());

        });

        Schema::create('report_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamp('created_at')->default(Carbon::now());
        });

        Schema::create('overdrawn_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('branch_code')->nullable();
            $table->date('trans_date')->nullable();
            $table->bigInteger('currency_id')->nullable();
            $table->string('balance')->nullable();
            $table->string('product_code')->nullable();
            $table->string('product_name')->nullable();
            $table->string('current_balance')->nullable();
            $table->bigInteger('account_officer_id')->nullable();
            $table->bigInteger('customer_id')->nullable();
            $table->string('emial')->nullable();
            $table->string('phone_number')->nullable();
            $table->bigInteger('gl_code')->nullable();

            $table->timestamp('created_at')->default(Carbon::now());
        });

        Schema::create('compliance_checklist', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->bigInteger('report_type_id')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->date('status')->nullable();
            $table->bigInteger('scope_id')->nullable();
            $table->string('key')->nullable();
            $table->string('timeline');
            $table->string('exception_details')->nullable();
            $table->string('exception_status')->nullable();
            $table->date('was_carried_out')->nullable();
            $table->string('recommendation')->nullable();
            $table->text('branches')->nullable();
            $table->string('action_taken')->nullable();
            $table->string('review_description')->nullable();
            $table->string('description')->nullable();
            $table->string('exception_noted')->nullable();
            $table->string('weightage')->nullable();
            $table->string('product')->nullable();

            $table->timestamp('created_at')->default(Carbon::now());
        });

        Schema::create('compliance_statistic', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('val')->nullable();
            $table->date('last_update')->nullable();
            $table->string('slug')->nullable();
            $table->string('status')->nullable();
            $table->string('process_order')->nullable();
            $table->string('char_format')->nullable();
            $table->string('category')->nullable();
            $table->bigInteger('branch_code')->nullable();
            $table->string('update_mode')->nullable();
            $table->string('description')->nullable();
            $table->string('risk_score')->nullable();
            $table->string('risk_assessment_id')->nullable();
            $table->timestamp('created_at')->default(Carbon::now());
        });

        Schema::create('compliance_stat_category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->timestamp('created_at')->default(Carbon::now());
        });


        Schema::create('dormant_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();
            $table->string('current_balance')->nullable();
            $table->date('dormancy_date')->nullable();
            $table->string('stoppage')->nullable();
            $table->string('account_type')->nullable();
            $table->string('date_opened')->nullable();
            $table->string('tin_number')->nullable();
            $table->string('bvn')->nullable();
            $table->string('closure_status')->nullable();
            $table->string('branch_code')->nullable();

            $table->timestamp('created_at')->default(Carbon::now());
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_type');
        Schema::dropIfExists('overdrawn_accounts');
        Schema::dropIfExists('compliance_checklist');
        Schema::dropIfExists('stmt_entry');
        Schema::dropIfExists('compliance_statistic');
        Schema::dropIfExists('compliance_stat_category');
        Schema::dropIfExists('dormant_accounts');

        

    }
};
