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
        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('locid');
            $table->unsignedBigInteger('userid');
            $table->double('latitude', 10, 6);
            $table->double('longitude', 10, 6);
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->integer('range')->nullable();
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('userid')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
};
