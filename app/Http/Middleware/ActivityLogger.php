<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\AktivitasLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if (Auth::check() && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $path = $request->path();
            $method = $request->method();
            
            // Tentukan aktivitas berdasarkan path dan method
            $aktivitas = $this->getAktivitasName($method, $path);
            $modul = $this->getModulName($path);

            if ($aktivitas && $modul) {
                AktivitasLog::create([
                    'user_id' => Auth::id(),
                    'aktivitas' => $aktivitas,
                    'modul' => $modul,
                    'deskripsi' => "Melakukan {$method} pada rute {$path}",
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                ]);
            }
        }

        return $response;
    }

    private function getAktivitasName($method, $path)
    {
        if ($method == 'POST') return 'Tambah Data';
        if (in_array($method, ['PUT', 'PATCH'])) return 'Ubah Data';
        if ($method == 'DELETE') return 'Hapus Data';
        return null;
    }

    private function getModulName($path)
    {
        $parts = explode('/', $path);
        return isset($parts[0]) ? ucfirst($parts[0]) : 'Sistem';
    }
}