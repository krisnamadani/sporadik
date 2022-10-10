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
        Schema::create('data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('tanggal');
            $table->string('nomor_pendaftaran_permohonan');
            $table->string('nama_identitas_alamat_penerima');
            $table->string('hasil_pekerjaan_yang_diterima');
            $table->string('jenis_kegiatan');
            $table->string('tanda_tangan_penerima');
            $table->string('no_seri_sertipikat');
            $table->string('keterangan');
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
        Schema::dropIfExists('data');
    }
};
