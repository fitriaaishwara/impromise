<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFoldersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('folders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('parent_id')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('folders');
    }
}
