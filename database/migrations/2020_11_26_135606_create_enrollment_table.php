<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnrollmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('students')
                ->onDelete('cascade');

            $table->foreignId('school_year_id')
                ->constrained('school_years')
                ->onDelete('cascade');

            $table->foreignId('grade_level_id')
                ->constrained('grade_levels')
                ->onDelete('cascade');

            $table->foreignId('section_id')
                ->constrained('sections')
                ->onDelete('cascade');

            $table->foreignId('sub_fee_id')
                ->constrained('sub_fees')
                ->onDelete('cascade');

            $table->foreignId('payment_mode_type_id')
                ->constrained('payment_mode_types')
                ->onDelete('cascade');

            $table->string('student_type');
            $table->string('enrollment_amount');
            $table->string('payment_receipt');
            $table->string('enrollment_code');
            $table->string('status');

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
        Schema::dropIfExists('enrollments');
    }
}
