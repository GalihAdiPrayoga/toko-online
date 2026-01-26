<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pembeli')->onDelete('cascade');
            $table->date('tanggal_transaksi');
            $table->string('daerah');
            $table->decimal('total_bayar', 12, 2)->default(0);
            $table->text('keterangan')->nullable();
            $table->enum('status', ['pending', 'dibayar', 'dikirim', 'selesai', 'batal'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
