<?php

namespace App\Services;

class PrometheeService
{
    public function hitung(array $alternatif, array $kriteria): array
    {
        $n = count($alternatif);
        if ($n == 0) return [];
        
        $pi = [];  // indeks preferensi
        
        // 1. Hitung deviasi & preferensi untuk setiap pasang
        foreach ($alternatif as $i => $a) {
            foreach ($alternatif as $j => $b) {
                if ($i === $j) {
                    $pi[$i][$j] = 0;
                    continue;
                }
                $pi[$i][$j] = $this->hitungIndeksPreferensi($a, $b, $kriteria);
            }
        }
        
        // 2. Hitung leaving, entering, net flow
        $hasil = [];
        foreach ($alternatif as $i => $a) {
            $leaving  = array_sum($pi[$i]) / ($n - 1);
            $entering = 0;
            foreach ($alternatif as $j => $b) {
                if ($i === $j) continue;
                $entering += $pi[$j][$i] ?? 0;
            }
            $entering /= ($n - 1);
            $hasil[$i] = [
                'alternatif' => $a,
                'leaving'    => $leaving,
                'entering'   => $entering,
                'net_flow'   => $leaving - $entering,
            ];
        }
        
        // 3. Sort berdasarkan net flow descending
        usort($hasil, fn($x, $y) => $y['net_flow'] <=> $x['net_flow']);
        
        return $hasil;
    }
    
    private function hitungIndeksPreferensi($a, $b, $kriteria): float 
    {
        $totalPreferensi = 0;
        $totalBobot = 0;

        foreach ($kriteria as $krit) {
            $field = $this->getKriteriaField($krit->nama_kriteria);
            if (!$field) continue;

            $valA = $a[$field] ?? 0;
            $valB = $b[$field] ?? 0;

            // Deviasi
            if ($krit->tipe == 'max') {
                $d = $valA - $valB;
            } else {
                $d = $valB - $valA;
            }

            $p = $this->fungsiPreferensi($d, $krit);
            $totalPreferensi += $p * $krit->bobot;
            $totalBobot += $krit->bobot;
        }

        return $totalBobot > 0 ? ($totalPreferensi / $totalBobot) : 0;
    }

    private function getKriteriaField($nama)
    {
        $map = [
            'Harga' => 'kriteria_harga',
            'Kualitas' => 'kriteria_kualitas',
            'Pengiriman' => 'kriteria_pengiriman',
            'Konsistensi' => 'kriteria_konsistensi',
        ];

        foreach ($map as $key => $val) {
            if (stripos(strtolower($nama), strtolower($key)) !== false) {
                return $val;
            }
        }
        return null;
    }

    private function fungsiPreferensi(float $d, $k): float 
    {
        if ($d <= 0) return 0;

        $p_param = $k->p_parameter ?? 0;
        $q_param = $k->q_parameter ?? 0;

        switch (strtolower($k->fungsi_preferensi)) {
            case 'usual': // Type I
                return 1;
            case 'u-shape': // Type II
                return $d > $q_param ? 1 : 0;
            case 'v-shape': // Type III
                return $d <= $p_param ? ($d / $p_param) : 1;
            case 'level': // Type IV
                if ($d <= $q_param) return 0;
                if ($d <= $p_param) return 0.5;
                return 1;
            case 'linear': // Type V
                if ($d <= $q_param) return 0;
                if ($d <= $p_param) return ($d - $q_param) / ($p_param - $q_param);
                return 1;
            default:
                return 1; // Default usual
        }
    }
}