<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('branch_code');
            $table->string('nomor_identitas');
            $table->string('nama_peserta');
            $table->string('no_telpon');
            $table->string('alamat');
            $table->integer('kode_pos');
            $table->string('jns_kelamin');
            $table->string('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->integer('usia');
            $table->timestamps();
            $table->softDeletes();
            // $table->foreign('branch_code')->references('branch_code')->on('branches')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
