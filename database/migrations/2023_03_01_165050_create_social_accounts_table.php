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
        Schema::create('social_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('influencer_id');
            $table->unsignedBigInteger('platform_id')->nullable();
            $table->unsignedBigInteger('influencer_class_id')->nullable();
            $table->string('username');
            $table->string('status')->default('unverified');
            $table->timestamps();

            $table->foreign('influencer_id')
                ->references('id')
                ->on('influencers')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreign('platform_id')
                ->references('id')
                ->on('platforms')
                ->onUpdate('cascade')
                ->onDelete('set null');

            $table->foreign('influencer_class_id')
                ->references('id')
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
        Schema::dropIfExists('social_accounts');
    }
};
