<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransaksiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($transaksis)
    {
        $this->data = $transaksis;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Kode',
            'Pelanggan',
            'Total',
            'Metode Bayar',
        ];
    }

    public function map($transaksi): array
    {
        return [
            $transaksi->tanggal ? $transaksi->tanggal->format('d/m/Y') : '-',
            $transaksi->kode_transaksi,
            $transaksi->pelanggan ? $transaksi->pelanggan->nama_pelanggan : 'Umum',
            'Rp ' . number_format($transaksi->total, 0, ',', '.'),
            $transaksi->metode_bayar,
        ];
    }
}
