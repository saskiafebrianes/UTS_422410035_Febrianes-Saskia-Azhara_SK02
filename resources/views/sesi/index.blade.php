@extends('layouts.app')

@section('title', 'Daftar Sesi Pengamatan')

@section('content')
<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-white">Daftar Sesi Pengamatan</h1>
        <p class="text-sm text-slate-400">Kelola jadwal pengamatan, detail lokasi, dan inventaris perlengkapan.</p>
    </div>
    <a href="{{ route('sesi.create') }}" class="bg-indigo-600 hover:bg-indigo-500 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
        + Tambah Sesi Baru
    </a>
</div>

<!-- Form Pencarian & Filter -->
<form method="GET" action="{{ route('sesi.index') }}" class="bg-slate-800/60 p-4 rounded-xl border border-slate-700 mb-6 flex flex-col md:flex-row gap-3">
    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kode atau nama sesi..."
        class="bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white flex-grow focus:outline-none focus:border-indigo-500">

    <select name="objek_id" class="bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:outline-none focus:border-indigo-500">
        <option value="">-- Semua Objek Sasaran --</option>
        @foreach($objekSasarans as $objek)
            <option value="{{ $objek->id }}" @selected(request('objek_id') == $objek->id)>
                {{ $objek->nama_objek }} ({{ $objek->kategori }})
            </option>
        @endforeach
    </select>

    <button type="submit" class="bg-slate-700 hover:bg-slate-600 text-white px-4 py-2 rounded-lg text-sm font-medium">
        Filter
    </button>
    @if(request()->hasAny(['q', 'objek_id']))
        <a href="{{ route('sesi.index') }}" class="bg-rose-900/50 hover:bg-rose-800/50 text-rose-300 px-4 py-2 rounded-lg text-sm font-medium text-center">
            Reset
        </a>
    @endif
</form>

<!-- Tabel Data -->
<div class="bg-slate-800/50 border border-slate-700 rounded-xl overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-950/70 text-slate-300 uppercase text-xs border-b border-slate-700">
            <tr>
                <th class="px-4 py-3">Kode & Nama Sesi</th>
                <th class="px-4 py-3">Objek Sasaran</th>
                <th class="px-4 py-3">Lokasi & Tanggal</th>
                <th class="px-4 py-3">Perlengkapan</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-700/70">
            @forelse($sesis as $sesi)
                <tr class="hover:bg-slate-800/80 transition">
                    <td class="px-4 py-3">
                        <div class="font-bold text-indigo-400">{{ $sesi->kode_sesi }}</div>
                        <div class="text-white">{{ $sesi->nama_sesi }}</div>
                    </td>
                    <td class="px-4 py-3">
                        <x-badge variant="amber">{{ $sesi->objekSasaran?->nama_objek ?? '-' }}</x-badge>
                    </td>
                    <td class="px-4 py-3">
                        <div class="text-slate-200">{{ $sesi->lokasiPengamatan?->nama_lokasi ?? '-' }}</div>
                        <div class="text-xs text-slate-400">{{ $sesi->tanggal_pengamatan }} ({{ $sesi->durasi_jam }} jam)</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1">
                            @foreach($sesi->perlengkapans as $alat)
                                <x-badge>{{ $alat->nama_alat }}</x-badge>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-4 py-3 text-right space-x-2 whitespace-nowrap">
                        <a href="{{ route('sesi.show', $sesi) }}" class="text-sky-400 hover:underline">Detail</a>
                        <a href="{{ route('sesi.edit', $sesi) }}" class="text-amber-400 hover:underline">Edit</a>
                        <form action="{{ route('sesi.destroy', $sesi) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus sesi pengamatan ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-rose-400 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-8 text-center text-slate-400">
                        Belum ada data sesi pengamatan yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $sesis->links() }}
</div>
@endsection
