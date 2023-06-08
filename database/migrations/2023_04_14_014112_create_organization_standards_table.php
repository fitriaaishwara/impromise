<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationStandardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('organization_standards', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('organization_id')->constrained('organizations');
            $table->uuid('standard_id')->constrained('standards');
            $table->text('scope');
            $table->boolean('status')->default(1)->comment('1: Active, 0: Non Active');
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->char('deleted_by')->nullable();
            $table->timestamps();
            $table->foreign('standard_id', 'organization_standards_standard_id_foreign')->references('id')->on('standards')->onDelete('cascade');
            $table->foreign('organization_id', 'organization_standards_organization_id_foreign')->references('id')->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('organization_standards');
    }
}
