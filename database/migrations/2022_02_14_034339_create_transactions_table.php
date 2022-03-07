<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('customer_id');
            $table->string('no_pk');
            $table->string('jenis_kredit');
            $table->string('jenis_cover');
            $table->string('periode_awal_asuransi');
            $table->string('periode_akhir_asuransi');
            $table->string('periode_asuransi');
            $table->string('tanggal_kredit');
            $table->integer('plafon_kredit');
            $table->integer('bayar_premi');
            $table->string('tgl_bayar_premi');
            $table->string('no_bukti_bayar');
            $table->string('akseptasi');
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
        Schema::dropIfExists('transactions');
    }
}
