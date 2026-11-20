<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiPengamatan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function objekSasaran() {
        return $this->belongsTo(ObjekSasaran::class);
    }

    public function lokasiPengamatan() {
        return $this->hasOne(LokasiPengamatan::class);
    }

    public function perlengkapans() {
        return $this->belongsToMany(Perlengkapan::class, 'sesi_perlengkapan', 'sesi_pengamatan_id', 'perlengkapan_id')
                    ->withPivot(['jumlah_unit', 'keterangan_penggunaan'])
                    ->withTimestamps();
    }
}
