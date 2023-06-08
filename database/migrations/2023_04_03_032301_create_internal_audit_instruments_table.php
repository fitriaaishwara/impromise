<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAuditInstrumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audit_instruments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('internal_audit_schedule_id')->constrained('internal_audit_schedules');
            $table->string('clause');
            $table->longText('question');
            $table->longText('observation');
            $table->char('instrument_status');
            $table->char('finding_status')->default(1);
            $table->boolean('status')->default(1)->comment('1: Active, 0: Non Active');
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->char('deleted_by')->nullable();
            $table->timestamps();
            $table->foreign('internal_audit_schedule_id')->references('id')->on('internal_audit_schedules')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('internal_audit_instruments');
    }
}
