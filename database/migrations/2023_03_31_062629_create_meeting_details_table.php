<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMeetingDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meeting_details', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('meeting_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('temporary_id')->nullable();
            $table->foreignUuid('department_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->text('discussion');
            $table->char('pic', 1)->comment('1: All, 2: User');
            $table->char('last_status', 1)->comment('1: Yes, 2: No, 3: Review Head Department, 4: Reject Head Department, 5: Review HRD, 6: Reject HRD');
            $table->date('due_date')->nullable();
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
        Schema::dropIfExists('meeting_details');
    }
}
