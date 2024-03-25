<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'transaksi';

    /**
     * Atribut yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'penyewaan_id',
        'jumlah_pembayaran',
        'keterangan',

    ];

    /**
     * Relasi ke tabel Penyewaan
     *
     * @return void
     */
    public function penyewaan()
    {
        return $this->belongsTo(Penyewaan::class);
    }

    /**
     * Relasi ke tabel HistoryTransaksi
     *
     * @return void
     */
    public function historyTransaksi()
    {
        return $this->hasMany(HistoryTransaksi::class);
    }
}
