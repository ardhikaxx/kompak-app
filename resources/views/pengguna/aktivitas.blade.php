@extends('layouts.app')
@section('title', 'Log Aktivitas Sistem')

@section('content')
<div class="page-header mb-4">
    <div>
        <h4 class="page-title mb-1">
            <i class="fas fa-list-ul me-2 text-accent"></i> Log Aktivitas Pengguna
        </h4>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Audit Trail</li>
            </ol>
        </nav>
    </div>
</div>

<div class="glass-card">
    <div class="table-responsive">
        <table class="table-glass">
            <thead>
                <tr>
                    <th width="15%">Waktu</th>
                    <th>Pengguna</th>
                    <th>Aktivitas</th>
                    <th>Modul</th>
                    <th>Deskripsi</th>
                    <th>IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="small">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    <td>
                        <div class="fw-bold text-white small">{{ $log->user->name ?? 'Sistem' }}</div>
                        <div class="text-white opacity-50" style="font-size: 0.65rem;">{{ ucfirst($log->user->role ?? '') }}</div>
                    </td>
                    <td>
                        @php
                            $badgeClass = 'badge-primary';
                            if($log->aktivitas == 'Tambah Data') $badgeClass = 'badge-success';
                            if($log->aktivitas == 'Ubah Data') $badgeClass = 'badge-info';
                            if($log->aktivitas == 'Hapus Data') $badgeClass = 'badge-danger';
                        @endphp
                        <span class="badge-glass {{ $badgeClass }}">{{ $log->aktivitas }}</span>
                    </td>
                    <td class="text-white fw-bold small">{{ $log->modul }}</td>
                    <td class="small text-white opacity-75">{{ $log->deskripsi }}</td>
                    <td class="font-mono small opacity-50">{{ $log->ip_address }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-white">
                        <i class="fas fa-history fa-3x mb-3 d-block"></i>
                        Belum ada log aktivitas yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($logs->hasPages())
    <div class="card-footer border-0 bg-transparent pt-3 pb-0">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection