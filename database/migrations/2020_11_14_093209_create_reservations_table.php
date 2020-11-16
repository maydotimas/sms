<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();

            $table->string('reservation_code');

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

            $table->string('student_type');
            $table->string('reservation_amount');
            $table->string('payment_receipt');

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
        Schema::dropIfExists('reservations');
    }
}
