<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSesiPengamatanRequest;
use App\Http\Requests\UpdateSesiPengamatanRequest;
use App\Models\ObjekSasaran;
use App\Models\Perlengkapan;
use App\Models\SesiPengamatan;
use App\Services\SesiPengamatanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SesiPengamatanController extends Controller
{
    public function __construct(
        private SesiPengamatanService $sesiService
    ) {}

    public function index(Request $request): View
    {
        $sesis = SesiPengamatan::query()
            ->with(['objekSasaran', 'lokasiPengamatan', 'perlengkapans'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $keyword = $request->input('q');
                $query->where(function ($q) use ($keyword) {
                    $q->where('kode_sesi', 'like', "%{$keyword}%")
                      ->orWhere('nama_sesi', 'like', "%{$keyword}%");
                });
            })
            ->when($request->filled('objek_id'), function ($query) use ($request) {
                $query->where('objek_sasaran_id', $request->integer('objek_id'));
            })
            ->latest('tanggal_pengamatan')
            ->paginate(10)
            ->withQueryString();

        $objekSasarans = ObjekSasaran::orderBy('nama_objek')->get();

        return view('sesi.index', compact('sesis', 'objekSasarans'));
    }

    public function create(): View
    {
        return view('sesi.create', [
            'objekSasarans' => ObjekSasaran::orderBy('nama_objek')->get(),
            'perlengkapans' => Perlengkapan::orderBy('nama_alat')->get(),
        ]);
    }

    public function store(StoreSesiPengamatanRequest $request): RedirectResponse
    {
        $this->sesiService->simpanSesi($request->validated());

        return redirect()
            ->route('sesi.index')
            ->with('success', 'Sesi pengamatan berhasil ditambahkan.');
    }

    public function show(SesiPengamatan $sesiPengamatan): View
    {
        $sesiPengamatan->load(['objekSasaran', 'lokasiPengamatan', 'perlengkapans']);

        return view('sesi.show', [
            'sesi' => $sesiPengamatan
        ]);
    }

    public function edit(SesiPengamatan $sesiPengamatan): View
    {
        $sesiPengamatan->load(['lokasiPengamatan', 'perlengkapans']);

        return view('sesi.edit', [
            'sesi' => $sesiPengamatan,
            'objekSasarans' => ObjekSasaran::orderBy('nama_objek')->get(),
            'perlengkapans' => Perlengkapan::orderBy('nama_alat')->get(),
            'selectedAlat' => $sesiPengamatan->perlengkapans->pluck('id')->all(),
        ]);
    }

    public function update(UpdateSesiPengamatanRequest $request, SesiPengamatan $sesiPengamatan): RedirectResponse
    {
        $this->sesiService->perbaruiSesi($sesiPengamatan, $request->validated());

        return redirect()
            ->route('sesi.index')
            ->with('success', 'Data sesi pengamatan berhasil diperbarui.');
    }

    public function destroy(SesiPengamatan $sesiPengamatan): RedirectResponse
    {
        $sesiPengamatan->delete();

        return redirect()
            ->route('sesi.index')
            ->with('success', 'Sesi pengamatan berhasil dihapus.');
    }
}
