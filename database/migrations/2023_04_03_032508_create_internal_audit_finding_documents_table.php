<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAuditFindingDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_finding_documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('finding_id')->constrained('internal_audit_findings');
            $table->uuid('attachment_id')->constrained('attachments');
            $table->string('temporary_id')->nullable();
            $table->boolean('status')->default(1)->comment('1: Active, 0: Non Active');
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->char('deleted_by')->nullable();
            $table->timestamps();
            $table->foreign('finding_id')->references('id')->on('internal_audit_findings')->onDelete('cascade');
            $table->foreign('attachment_id')->references('id')->on('attachments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_audit_finding_documents');
    }
}
