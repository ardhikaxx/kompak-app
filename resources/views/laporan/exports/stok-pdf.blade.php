<!DOCTYPE html>
<html>
<head>
    <title>Laporan Stok Barang</title>
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
        .badge {
            padding: 2px 5px;
            border-radius: 3px;
            font-size: 10px;
            color: white;
        }
        .bg-success { background-color: #28a745; }
        .bg-danger { background-color: #dc3545; }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN STOK BARANG KOMPAK</h1>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="150">Periode</td>
                <td>: {{ \Carbon\Carbon::parse($startDate)->format('d F Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Total Masuk</td>
                <td>: {{ number_format($totalMasuk, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Total Keluar</td>
                <td>: {{ number_format($totalKeluar, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>Jenis</th>
                <th class="text-right">Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stokLogs as $log)
            <tr>
                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>
                <td>{{ $log->produk->nama_produk }}</td>
                <td>
                    @if($log->jenis_perubahan == 'masuk')
                        Masuk
                    @else
                        Keluar
                    @endif
                </td>
                <td class="text-right">{{ number_format($log->jumlah, 0, ',', '.') }}</td>
                <td>{{ $log->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        Dicetak pada: {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html>
