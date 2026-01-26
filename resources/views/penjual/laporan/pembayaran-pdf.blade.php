<!-- filepath: c:\laragon\www\toko-online\resources\views\penjual\laporan\pembayaran-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pembayaran</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
    </style>
</head>
<body>
    <h1>Laporan Pembayaran</h1>
    <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID Transaksi</th>
                <th>Pembeli</th>
                <th>Waktu Bayar</th>
                <th>Metode</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pembayaran as $bayar)
            <tr>
                <td>#{{ $bayar->transaksi_id }}</td>
                <td>{{ $bayar->transaksi->pembeli->nama_pembeli }}</td>
                <td>{{ $bayar->waktu_pembayaran->format('d/m/Y H:i') }}</td>
                <td>{{ ucfirst($bayar->metode) }}</td>
                <td class="text-right">Rp {{ number_format($bayar->total, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>Total Pembayaran:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
