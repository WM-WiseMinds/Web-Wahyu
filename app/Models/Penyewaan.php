<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penyewaan extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'penyewaan';

    /**
     * Atribut yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'pelanggan_id',
        'mobil_id',
        'user_id',
        'tanggal_penyewaan',
        'durasi_sewa',
    ];

    /**
     * Relasi ke tabel Mobil
     *
     * @return void
     */
    public function mobil()
    {
        return $this->belongsTo(Mobil::class);
    }

    /**
     * Relasi ke tabel Pelanggan
     *
     * @return void
     */
    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class);
    }

    /**
     * Relasi ke tabel User
     *
     * @return void
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke tabel Transaksi
     *
     * @return void
     */
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}
