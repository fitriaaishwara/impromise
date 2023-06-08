<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAuditAuditorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_auditors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('internal_audit_id')->constrained('internal_audits');
            $table->uuid('user_id')->costrained('users');
            $table->char('role');
            $table->timestamps();
            $table->foreign('internal_audit_id', 'internal_audit_auditors_internal_audit_id_foreign')->references('id')->on('internal_audits')->onDelete('cascade');
            $table->foreign('user_id', 'internal_audit_auditors_user_id_foreign')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_audit_auditors');
    }
}
