<?php

namespace App\Models;

use Carbon\Carbon;
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

    protected $dates = ['tanggal_penyewaan'];

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

    /**
     * Relasi ke tabel PerubahanPenyewaan
     *
     * @return void
     */
    public function perubahanPenyewaan()
    {
        return $this->hasMany(PerubahanPenyewaan::class);
    }

    /**
     * Mutator untuk mengatur tanggal pengembalian
     *
     * @return void
     */
    public function getReturnDateAttribute()
    {
        return Carbon::parse($this->tanggal_penyewaan)->addDays((int) $this->durasi_sewa);
    }
}
