<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubFeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_fees', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->string('description');
            $table->enum('type',['REGULAR','SIBLING','SCHOLAR','DISCOUNT']);
            $table->string('misc')->default(0);
            $table->string('tuition')->default(0);
            $table->string('discount')->default(0);
            $table->foreignId('fee_id')
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
        Schema::dropIfExists('sub_fees');
    }
}
