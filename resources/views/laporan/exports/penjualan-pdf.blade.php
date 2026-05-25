<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            text-transform: uppercase;
            color: #1a1a1a;
        }
        .info {
            margin-bottom: 20px;
        }
        .info table {
            width: 100%;
        }
        .info td {
            padding: 5px 0;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENJUALAN KOMPAK</h1>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="150">Periode</td>
                <td>: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Total Transaksi</td>
                <td>: {{ number_format($totalTransaksi, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Pendapatan</td>
                <td>: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <h3>Daftar Transaksi</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kode Transaksi</th>
                <th>Pelanggan</th>
                <th>Metode</th>
                <th class="text-right">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $t)
            <tr>
                <td>{{ \Carbon\Carbon::parse($t->tanggal_transaksi)->format('d/m/Y') }}</td>
                <td>{{ $t->kode_transaksi }}</td>
                <td>{{ $t->pelanggan->nama_pelanggan ?? 'Umum' }}</td>
                <td>{{ ucfirst($t->metode_pembayaran) }}</td>
                <td class="text-right">Rp {{ number_format($t->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h3>Top 5 Produk Terlaris</h3>
    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th class="text-right">Jumlah Terjual</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topProduk as $index => $p)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $p->nama_produk }}</td>
                <td class="text-right">{{ number_format($p->total_qty, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>
