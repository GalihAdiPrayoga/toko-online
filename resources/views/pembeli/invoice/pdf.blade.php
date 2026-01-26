<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $transaksi->id }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h1 { margin: 0; font-size: 24px; }
        .info-row { display: table; width: 100%; margin-bottom: 20px; }
        .info-col { display: table-cell; width: 50%; vertical-align: top; }
        .info-col h3 { margin: 0 0 10px 0; font-size: 14px; }
        .info-col p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f5f5f5; font-weight: bold; }
        .text-right { text-align: right; }
        .totals { width: 250px; margin-left: auto; }
        .totals td { border: none; padding: 5px 10px; }
        .totals .total-row { font-weight: bold; font-size: 14px; border-top: 2px solid #333; }
        .payment-info { background-color: #e8f5e9; padding: 15px; margin-top: 20px; }
        .footer { text-align: center; margin-top: 40px; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE</h1>
        <p>#{{ str_pad($transaksi->id, 6, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="info-row">
        <div class="info-col">
            <h3>Dari:</h3>
            <p><strong>Toko Online</strong></p>
            <p>Jl. Merdeka No. 123</p>
            <p>support@toko.com</p>
        </div>
        <div class="info-col">
            <h3>Kepada:</h3>
            <p><strong>{{ $transaksi->pembeli->nama_pembeli }}</strong></p>
            <p>{{ $transaksi->pembeli->alamat ?? '-' }}</p>
            <p>{{ $transaksi->pembeli->no_hp ?? '-' }}</p>
        </div>
    </div>

    <p><strong>Tanggal Transaksi:</strong> {{ $transaksi->tanggal_transaksi->format('d/m/Y') }}</p>
    <p><strong>Daerah Pengiriman:</strong> {{ $transaksi->daerah }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Produk</th>
                <th class="text-right">Harga</th>
                <th class="text-right">Qty</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @php $subtotal = 0; @endphp
            @foreach($transaksi->detailTransaksi as $index => $detail)
            @php $subtotal += $detail->subtotal; @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $detail->produk->nama_produk }}</td>
                <td class="text-right">Rp {{ number_format($detail->harga_produk, 0, ',', '.') }}</td>
                <td class="text-right">{{ $detail->jumlah_produk }}</td>
                <td class="text-right">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td>Subtotal:</td>
            <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Ongkos Kirim:</td>
            <td class="text-right">Rp {{ number_format($ongkosKirim->biaya ?? 0, 0, ',', '.') }}</td>
        </tr>
        <tr class="total-row">
            <td>Total:</td>
            <td class="text-right">Rp {{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
        </tr>
    </table>

    @if($transaksi->pembayaran)
    <div class="payment-info">
        <h3>Informasi Pembayaran</h3>
        <p><strong>Metode:</strong> {{ ucfirst($transaksi->pembayaran->metode) }}</p>
        <p><strong>Waktu Pembayaran:</strong> {{ $transaksi->pembayaran->waktu_pembayaran->format('d/m/Y H:i') }}</p>
        <p><strong>Status:</strong> Lunas</p>
    </div>
    @endif

    <div class="footer">
        <p>Terima kasih telah berbelanja di Toko Online!</p>
        <p>Invoice ini dicetak pada {{ date('d/m/Y H:i') }}</p>
    </div>
</body>
</html>
