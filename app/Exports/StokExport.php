<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class StokExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($stokLogs)
    {
        $this->data = $stokLogs;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Produk',
            'Jenis',
            'Jumlah',
            'Keterangan',
        ];
    }

    public function map($log): array
    {
        return [
            $log->created_at ? $log->created_at->format('d/m/Y H:i') : '-',
            $log->produk ? $log->produk->nama_produk : '-',
            $log->jenis,
            $log->jumlah,
            $log->keterangan,
        ];
    }
}
