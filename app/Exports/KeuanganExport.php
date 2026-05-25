<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class KeuanganExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($keuangans)
    {
        $this->data = $keuangans;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Jenis',
            'Kategori',
            'Jumlah',
            'Keterangan',
        ];
    }

    public function map($keuangan): array
    {
        return [
            $keuangan->tanggal ? $keuangan->tanggal->format('d/m/Y') : '-',
            $keuangan->jenis,
            $keuangan->kategori,
            'Rp ' . number_format($keuangan->jumlah, 0, ',', '.'),
            $keuangan->keterangan,
        ];
    }
}
