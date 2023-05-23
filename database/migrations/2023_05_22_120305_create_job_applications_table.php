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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('opening_id');
            $table->string('name');
            $table->string('email');
            $table->string('national_id');
            $table->decimal('age',3,0);
            $table->string('cv_path')->nullable();
            $table->string('trait')->nullable();
            $table->string('status')->default('received');
            $table->timestamps();

            $table->foreign('opening_id')
                ->references('id')
                ->on('openings')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_applications');
    }
};
