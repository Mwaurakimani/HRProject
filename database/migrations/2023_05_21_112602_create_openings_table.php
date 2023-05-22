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
        Schema::create('openings', function (Blueprint $table) {
            $table->id();
            $table->string('Title');
            $table->text('Description')->nullable();
            $table->text('About')->nullable();
            $table->text('Responsibilities')->nullable();
            $table->text('Qualification')->nullable();
            $table->text('Education');
            $table->text('Skills');
            $table->string('Model');
            $table->text('Questions')->nullable();
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
        Schema::dropIfExists('openings');
    }
};
