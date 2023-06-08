<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAuditFindingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_findings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('internal_audit_instrument_id')->constrained('internal_audit_instruments');
            $table->longText('analysis');
            $table->longText('correction');
            $table->longText('corrective');
            $table->longText('review')->nullable();
            $table->boolean('suitable')->default(0);
            $table->boolean('status')->default(1)->comment('1: Active, 0: Non Active');
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->char('deleted_by')->nullable();
            $table->timestamps();
            $table->foreign('internal_audit_instrument_id')->references('id')->on('internal_audit_instruments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_audit_findings');
    }
}
