<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'mobil';

    /**
     * Atribut yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'nama',
        'merk',
        'warna',
        'tahun',
        'plat_nomor',
        'keterangan',
        'harga',
        'status',
        'kapasitas_penumpang',
        'foto',
    ];

    /**
     * Relasi ke tabel Penyewaan
     *
     * @return void
     */
    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class);
    }

    /**
     * Relasi ke tabel Samsat
     *
     * @return void
     */
    public function samsat()
    {
        return $this->hasMany(Samsat::class);
    }

    /**
     * Relasi ke tabel Pemeliharaan
     *
     * @return void
     */
    public function pemeliharaan()
    {
        return $this->hasMany(Pemeliharaan::class);
    }
}
