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
        Schema::create('days', function (Blueprint $table) {
            $table->id();
            $table->foreignId(column:'user_id')->references('user_id')->on('experts')->onDelete('cascade');
            $table->boolean('sunday');
            $table->boolean('monday');
            $table->boolean('tuesday');
            $table->boolean('wednsday');
            $table->boolean('thursday');
            $table->boolean('friday');
            $table->boolean('saturday');
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
        Schema::dropIfExists('days');
    }
};
