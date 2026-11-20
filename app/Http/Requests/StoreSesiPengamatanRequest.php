<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSesiPengamatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'objek_sasaran_id' => ['required', 'exists:objek_sasarans,id'],
            'kode_sesi' => ['required', 'string', 'max:30', 'unique:sesi_pengamatans,kode_sesi'],
            'nama_sesi' => ['required', 'string', 'max:150'],
            'tanggal_pengamatan' => ['required', 'date'],
            'durasi_jam' => ['required', 'numeric', 'min:0.5', 'max:24'],

            // Validasi Relasi One-to-One (Lokasi Pengamatan)
            'nama_lokasi' => ['required', 'string', 'max:120'],
            'koordinat_langit' => ['required', 'string', 'max:100'],
            'tingkat_polusi_cahaya' => ['nullable', 'string', 'max:50'],
            'catatan_cuaca' => ['nullable', 'string'],

            // Validasi Relasi Many-to-Many (Pilihan Jamak Perlengkapan)
            'perlengkapan_ids' => ['required', 'array', 'min:1'],
            'perlengkapan_ids.*' => ['integer', 'exists:perlengkapans,id'],
        ];
    }
}
