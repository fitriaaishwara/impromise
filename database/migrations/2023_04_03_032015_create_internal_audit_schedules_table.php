<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAuditSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_schedules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('internal_audit_id')->constrained('internal_audits');
            $table->uuid('department_id')->constrained('departments');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->longText('process');
            $table->boolean('status')->default(1)->comment('1: Active, 0: Non Active');
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->char('deleted_by')->nullable();
            $table->timestamps();
            $table->foreign('internal_audit_id')->references('id')->on('internal_audits')->onDelete('cascade');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_audit_schedules');
    }
}
