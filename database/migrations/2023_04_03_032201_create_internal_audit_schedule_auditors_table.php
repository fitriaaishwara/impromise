<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAuditScheduleAuditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_schedule_auditors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('internal_audit_schedule_id')->constrained('internal_audit_schedules');
            $table->uuid('user_id')->constrained('users');
            $table->foreign('internal_audit_schedule_id', 'internal_audit_schedule_id_foreign')->references('id')->on('internal_audit_schedules')->onDelete('cascade');
            $table->foreign('user_id', 'internal_audit_schedule_auditors_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_audit_schedule_auditors');
    }
}
