<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->string('post_location');
            $table->json('targets');
            $table->unsignedBigInteger('influencer_classes_id')->nullable();
            $table->timestamps();

            $table->foreign('project_id')->references('id')
                ->on('projects')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('platform_id')->references('id')
                ->on('platforms')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('influencer_classes_id')->references('id')
                ->on('influencer_classes')
                ->onUpdate('cascade')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_requirements');
    }
};
