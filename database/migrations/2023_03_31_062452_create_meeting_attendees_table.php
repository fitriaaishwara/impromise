<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingAttendeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_attendees', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('meeting_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->string('role');
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
        Schema::dropIfExists('meeting_attendees');
    }
}
