<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_audits', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date');
            $table->longText('location');
            $table->longText('note')->nullable();
            $table->boolean('status')->default(1)->comment('1: Active, 0: Non Active');
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->char('deleted_by')->nullable();
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
        Schema::dropIfExists('internal_audits');
    }
}
