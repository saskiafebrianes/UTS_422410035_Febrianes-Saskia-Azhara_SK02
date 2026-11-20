<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSesiPengamatanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $sesiId = $this->route('sesiPengamatan')->id;

        return [
            'objek_sasaran_id' => ['required', 'exists:objek_sasarans,id'],
            'kode_sesi' => ['required', 'string', 'max:30', Rule::unique('sesi_pengamatans', 'kode_sesi')->ignore($sesiId)],
            'nama_sesi' => ['required', 'string', 'max:150'],
            'tanggal_pengamatan' => ['required', 'date'],
            'durasi_jam' => ['required', 'numeric', 'min:0.5', 'max:24'],

            'nama_lokasi' => ['required', 'string', 'max:120'],
            'koordinat_langit' => ['required', 'string', 'max:100'],
            'tingkat_polusi_cahaya' => ['nullable', 'string', 'max:50'],
            'catatan_cuaca' => ['nullable', 'string'],

            'perlengkapan_ids' => ['required', 'array', 'min:1'],
            'perlengkapan_ids.*' => ['integer', 'exists:perlengkapans,id'],
        ];
    }
}
