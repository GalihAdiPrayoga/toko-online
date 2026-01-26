<!-- filepath: c:\laragon\www\toko-online\resources\views\penjual\laporan\transaksi-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        h1 { text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; }
        .text-right { text-align: right; }
        .total { font-weight: bold; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Laporan Transaksi</h1>
    <p>Tanggal Cetak: {{ date('d/m/Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Pembeli</th>
                <th>Daerah</th>
                <th>Status</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotal = 0; @endphp
            @foreach($transaksi as $trx)
            @php $grandTotal += $trx->total_bayar; @endphp
            <tr>
                <td>#{{ $trx->id }}</td>
                <td>{{ $trx->tanggal_transaksi->format('d/m/Y') }}</td>
                <td>{{ $trx->pembeli->nama_pembeli }}</td>
                <td>{{ $trx->daerah }}</td>
                <td>{{ ucfirst($trx->status) }}</td>
                <td class="text-right">Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="text-right"><strong>Grand Total:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($grandTotal, 0, ',', '.') }}</strong></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>
