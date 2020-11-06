<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolYearConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('school_year_configs');
        Schema::create('school_year_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_year_id')
                ->constrained('school_years')
                ->onDelete('cascade');
            $table->foreignId('department_id')
                ->constrained('departments')
                ->onDelete('cascade');
            $table->foreignId('fees_id')
                ->constrained('fees')
                ->onDelete('cascade');
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
        Schema::dropIfExists('school_year_configs');
    }
}
