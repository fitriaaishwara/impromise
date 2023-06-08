<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAuditsStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audits_standards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('internal_audit_id')->constrained('internal_audits');
            $table->uuid('standard_id')->constrained('standards');
            $table->timestamps();
            $table->foreign('internal_audit_id', 'internal_audits_standards_internal_audit_id_foreign')->references('id')->on('internal_audits')->onDelete('cascade');
            $table->foreign('standard_id', 'internal_audits_standards_standard_id_foreign')->references('id')->on('standards')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_audits_standards');
    }
}
