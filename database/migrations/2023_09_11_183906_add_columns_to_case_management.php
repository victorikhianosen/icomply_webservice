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

        Schema::table('users', function (Blueprint $table) {
            $table->integer('department_id')->nullable();

            $table->foreign('department_id')
            ->references('id')->on('department')->onDelete('cascade');

        });

        Schema::table('case_management', function (Blueprint $table) {
            $table->date('close_date')->nullable();
            $table->integer('alert_id')->nullable();
            $table->string('close_remarks')->nullable();
            $table->string('attachment')->nullable();
            $table->string('attachment_mime_type')->nullable();
            $table->string('attachment_filename')->nullable();
            $table->integer('customer_id')->nullable();

            $table->foreign('customer_id')
                ->references('id')->on('am_customer_account')->onDelete('cascade');

            $table->foreign('alert_id')
                ->references('id')->on('alert')->onDelete('cascade');
        });

        Schema::table('alert', function (Blueprint $table) {


            $table->foreign('status_id')
                ->references('id')->on('case_status')->onDelete('cascade');

            $table->foreign('alert_frequency_id')
            ->references('id')->on('exception_frequency')->onDelete('cascade');

            $table->foreign('team_id')
            ->references('id')->on('department')->onDelete('cascade');

            $table->foreign('exception_process_id')
            ->references('id')->on('exception_process')->onDelete('cascade');
        });

        Schema::table('ctl_document', function (Blueprint $table) {
            $table->foreign('user_id')
                ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('document_type_id')
            ->references('id')->on('ctl_document_type')->onDelete('cascade');

            $table->foreign('first_owner_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('second_owner_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('approver_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('team_id')
                ->references('id')->on('department')->onDelete('cascade');

            $table->foreign('exception_process_id')
            ->references('id')->on('exception_process')->onDelete('cascade');
        });

        Schema::table('am_dormant_accounts', function (Blueprint $table) {
            $table->foreign('branch_code')
                ->references('id')->on('ctl_branch')->onDelete('cascade');

            $table->foreign('account_number')
            ->references('id')->on('am_customer_account')->onDelete('cascade');

            $table->foreign('account_type')
            ->references('tier_id')->on('am_customer_tier')->onDelete('cascade');
        });

        Schema::table('am_customer_account', function (Blueprint $table) {
            $table->foreign('ext_rowid')
            ->references('id')->on('ctl_branch')->onDelete('cascade');

            $table->foreign('branch_code')
            ->references('id')->on('ctl_branch')->onDelete('cascade');

            $table->foreign('customer_id')
            ->references('id')->on('am_customer')->onDelete('cascade');

                                            
        });

        Schema::table('compliance_checklist', function (Blueprint $table) {

            $table->foreign('branch_code')
            ->references('id')->on('ctl_branch')->onDelete('cascade');

        });

        Schema::table('ctl_control_officer', function (Blueprint $table) {

            $table->foreign('employee_id')
            ->references('id')->on('users')->onDelete('cascade');
            $table->foreign('alert_group_id')
            ->references('id')->on('ctl_alert_group')->onDelete('cascade');
        });
        

        Schema::table('ctl_overdrawn_accounts', function (Blueprint $table) {

            $table->foreign('currency_id')
            ->references('id')->on('ctl_currency')->onDelete('cascade');

            $table->foreign('customer_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('account_officer_id')
            ->references('id')->on('ctl_control_officer')->onDelete('cascade');
        });

        Schema::table('ctl_system', function (Blueprint $table) {

            $table->foreign('process_category')
            ->references('id')->on('exception_process_type')->onDelete('cascade');

            $table->foreign('owner_1')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('owner_2')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('approver_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('exception_process_id')
            ->references('id')->on('exception_process')->onDelete('cascade');

            $table->foreign('category_id')
            ->references('id')->on('ctl_system_category')->onDelete('cascade');
        });

        Schema::table('ctl_system_allocation', function (Blueprint $table) {

            $table->foreign('system_id')
            ->references('id')->on('system')->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('responsible_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('approver_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('category_id')
            ->references('id')->on('ctl_system_category')->onDelete('cascade');
        });

        Schema::table('exception_process', function (Blueprint $table) {
            

            $table->foreign('first_owner_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('second_owner_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('user_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('approved_id')
            ->references('id')->on('users')->onDelete('cascade');

            $table->foreign('process_id')
            ->references('id')->on('exception_process_type')->onDelete('cascade');

            $table->foreign('alert_group_id')
            ->references('id')->on('ctl_alert_group')->onDelete('cascade');
        });

        Schema::table('exception_process', function (Blueprint $table) {


            $table->foreign('customer_id')
            ->references('id')->on('am_customer')->onDelete('cascade');

            $table->foreign('currency_id')
            ->references('id')->on('ctl_currency')->onDelete('cascade');

            $table->foreign('department_code')
                ->references('id')->on('department')->onDelete('cascade');


            $table->foreign('system_id')
            ->references('id')->on('system')->onDelete('cascade');

            
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
            $table->dropColumn('new_column1');
            $table->dropColumn('new_column2');
        });
    }
};
