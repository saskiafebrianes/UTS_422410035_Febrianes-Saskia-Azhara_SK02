<?php

use App\Http\Controllers\SesiPengamatanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('sesi.index');
});

Route::resource('sesi', SesiPengamatanController::class)->parameters([
    'sesi' => 'sesiPengamatan'
]);
