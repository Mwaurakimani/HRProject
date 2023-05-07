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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('marketer_id');
            $table->string('title');
            $table->string('type');
            $table->text('description')->nullable();
            $table->string('budget');
            $table->string('metrics');
            $table->string('runtime');
            $table->text('notes')->nullable();
            $table->string('location')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->foreign('marketer_id')
                ->references('id')
                ->on('marketers')
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
        Schema::dropIfExists('projects');
    }
};
