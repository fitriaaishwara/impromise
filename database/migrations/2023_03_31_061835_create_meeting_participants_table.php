<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingParticipantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_participants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('meeting_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('department_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->nullable()->constrained()->cascadeOnDelete();
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
        Schema::dropIfExists('meeting_participants');
    }
}
