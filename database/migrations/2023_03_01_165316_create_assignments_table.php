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
        Schema::create('assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('bid_id');
            $table->decimal('agreed_price',15,2);
            $table->string('marketer_status')->default('running');
            $table->string('influencer_status')->default('running');
            $table->string('general_status')->default('running');
            $table->timestamps();

            $table->foreign('bid_id')
                ->references('id')
                ->on('bids')
                ->onUpdate('cascade')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('assignments');
    }
};
