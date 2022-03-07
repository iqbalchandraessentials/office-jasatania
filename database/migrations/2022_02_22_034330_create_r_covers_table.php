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
        Schema::create('r_covers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transcation_id');
            $table->string('rate_code', 20);
            $table->float('rate');
            $table->string('description', 191);
            $table->date('sdate');
            $table->date('edate');
            $table->timestamps();
            // $table->foreign('acceptance_id')->references('id')->on('transcation')->onUpdate('RESTRICT')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('r_covers');
    }
};
