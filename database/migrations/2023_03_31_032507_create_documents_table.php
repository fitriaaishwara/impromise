<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('folder_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('attachment_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('no_document');
            $table->date('date');
            $table->integer('revisi');
            $table->text('description')->nullable();
            $table->char('extension', 5);
            $table->integer('size')->default(0);
            $table->integer('download')->default(0);
            $table->boolean('status')->default(1)->comment('1: Active, 0: Non Active');
            $table->char('created_by')->nullable();
            $table->char('updated_by')->nullable();
            $table->char('deleted_by')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
