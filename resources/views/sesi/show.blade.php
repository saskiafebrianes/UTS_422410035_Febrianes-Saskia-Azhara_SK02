@extends('layouts.app')

@section('title', 'Detail Sesi Pengamatan')

@section('content')
<div class="max-w-3xl mx-auto bg-slate-800/60 border border-slate-700 rounded-xl p-6 space-y-6">
    <div class="flex justify-between items-start border-b border-slate-700 pb-4">
        <div>
            <x-badge variant="amber">{{ $sesi->objekSasaran?->nama_objek ?? '-' }}@if($sesi->objekSasaran) ({{ $sesi->objekSasaran->kategori }})@endif</x-badge>
            <h1 class="text-2xl font-bold text-white mt-2">{{ $sesi->nama_sesi }}</h1>
            <p class="text-sm text-indigo-400 font-mono">{{ $sesi->kode_sesi }}</p>
        </div>
        <a href="{{ route('sesi.index') }}" class="px-3 py-1.5 bg-slate-700 hover:bg-slate-600 rounded-lg text-xs text-white">
            &larr; Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
        <div class="bg-slate-900/70 p-4 rounded-lg border border-slate-700/70">
            <h3 class="font-semibold text-indigo-400 mb-2">Informasi Waktu</h3>
            <p><span class="text-slate-400">Tanggal:</span> {{ $sesi->tanggal_pengamatan }}</p>
            <p><span class="text-slate-400">Durasi:</span> {{ $sesi->durasi_jam }} Jam</p>
        </div>

        <div class="bg-slate-900/70 p-4 rounded-lg border border-slate-700/70">
            <h3 class="font-semibold text-indigo-400 mb-2">Detail Lokasi (1:1)</h3>
            <p><span class="text-slate-400">Lokasi:</span> {{ $sesi->lokasiPengamatan?->nama_lokasi ?? '-' }}</p>
            <p><span class="text-slate-400">Koordinat:</span> {{ $sesi->lokasiPengamatan?->koordinat_langit ?? '-' }}</p>
            <p><span class="text-slate-400">Polusi Cahaya:</span> {{ $sesi->lokasiPengamatan?->tingkat_polusi_cahaya ?? '-' }}</p>
            <p><span class="text-slate-400">Cuaca:</span> {{ $sesi->lokasiPengamatan?->catatan_cuaca ?? '-' }}</p>
        </div>
    </div>

    <div class="bg-slate-900/70 p-4 rounded-lg border border-slate-700/70 text-sm">
        <h3 class="font-semibold text-indigo-400 mb-3">Perlengkapan Digunakan (N:M)</h3>
        <ul class="list-disc list-inside space-y-1 text-slate-200">
            @forelse($sesi->perlengkapans as $alat)
                <li>
                    <span class="font-semibold">{{ $alat->kode_alat }}</span> - {{ $alat->nama_alat }}
                    <span class="text-xs text-slate-400">({{ $alat->pivot->keterangan_penggunaan ?? '-' }})</span>
                </li>
            @empty
                <li class="text-slate-400">Tidak ada perlengkapan tercatat.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
