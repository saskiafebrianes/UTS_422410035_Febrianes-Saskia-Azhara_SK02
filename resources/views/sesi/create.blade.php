@extends('layouts.app')

@section('title', 'Tambah Sesi Pengamatan')

@section('content')
<div class="max-w-3xl mx-auto bg-slate-800/60 border border-slate-700 rounded-xl p-6">
    <h1 class="text-xl font-bold text-white mb-6">Tambah Sesi Pengamatan Baru</h1>

    <form action="{{ route('sesi.store') }}" method="POST" class="space-y-5">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-slate-300 mb-1">Kode Sesi *</label>
                <input type="text" name="kode_sesi" value="{{ old('kode_sesi') }}" placeholder="Contoh: SESI-2026-01"
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
                @error('kode_sesi') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-slate-300 mb-1">Objek Sasaran *</label>
                <select name="objek_sasaran_id" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
                    <option value="">-- Pilih Objek --</option>
                    @foreach($objekSasarans as $objek)
                        <option value="{{ $objek->id }}" @selected(old('objek_sasaran_id') == $objek->id)>
                            {{ $objek->nama_objek }} ({{ $objek->kategori }})
                        </option>
                    @endforeach
                </select>
                @error('objek_sasaran_id') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm text-slate-300 mb-1">Nama Sesi Pengamatan *</label>
            <input type="text" name="nama_sesi" value="{{ old('nama_sesi') }}" placeholder="Pengamatan Galaksi Andromeda"
                class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
            @error('nama_sesi') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-slate-300 mb-1">Tanggal Pengamatan *</label>
                <input type="date" name="tanggal_pengamatan" value="{{ old('tanggal_pengamatan') }}"
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
                @error('tanggal_pengamatan') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-slate-300 mb-1">Durasi (Jam) *</label>
                <input type="number" step="0.5" name="durasi_jam" value="{{ old('durasi_jam', 2.0) }}"
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
                @error('durasi_jam') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <hr class="border-slate-700">
        <h2 class="text-md font-semibold text-indigo-400">Detail Lokasi Pengamatan (1:1)</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-slate-300 mb-1">Nama Lokasi *</label>
                <input type="text" name="nama_lokasi" value="{{ old('nama_lokasi') }}" placeholder="Observatorium Bosscha"
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
                @error('nama_lokasi') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm text-slate-300 mb-1">Koordinat Langit (RA / Dec) *</label>
                <input type="text" name="koordinat_langit" value="{{ old('koordinat_langit') }}" placeholder="RA 00h 42m / Dec +41° 16'"
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
                @error('koordinat_langit') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-slate-300 mb-1">Tingkat Polusi Cahaya (Bortle)</label>
                <input type="text" name="tingkat_polusi_cahaya" value="{{ old('tingkat_polusi_cahaya') }}" placeholder="Bortle Class 3"
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
            </div>

            <div>
                <label class="block text-sm text-slate-300 mb-1">Catatan Cuaca</label>
                <input type="text" name="catatan_cuaca" value="{{ old('catatan_cuaca') }}" placeholder="Cerah berawan tipis"
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white">
            </div>
        </div>

        <hr class="border-slate-700">
        <h2 class="text-md font-semibold text-indigo-400">Perlengkapan yang Digunakan (Pilihan Jamak) *</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 bg-slate-900 p-4 rounded-lg border border-slate-700">
            @foreach($perlengkapans as $alat)
                <label class="flex items-center space-x-2 text-sm text-slate-200 cursor-pointer">
                    <input type="checkbox" name="perlengkapan_ids[]" value="{{ $alat->id }}"
                        @checked(in_array($alat->id, old('perlengkapan_ids', [])))
                        class="rounded border-slate-600 text-indigo-600 focus:ring-indigo-500">
                    <span>{{ $alat->kode_alat }} - {{ $alat->nama_alat }}</span>
                </label>
            @endforeach
        </div>
        @error('perlengkapan_ids') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('sesi.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm text-white">Batal</a>
            <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-500 rounded-lg text-sm font-medium text-white">Simpan Sesi</button>
        </div>
    </form>
</div>
@endsection
