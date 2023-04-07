<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('program_code')->nullable();
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('program_type');
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
        Schema::dropIfExists('promotion_programs');
    }
};
