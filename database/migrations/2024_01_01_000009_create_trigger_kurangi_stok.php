<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared('
            CREATE TRIGGER kurangi_stok_after_insert
            AFTER INSERT ON detail_transaksi
            FOR EACH ROW
            BEGIN
                UPDATE produk
                SET stok = stok - NEW.jumlah_produk
                WHERE id = NEW.produk_id;
            END
        ');
    }

    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS kurangi_stok_after_insert');
    }
};
