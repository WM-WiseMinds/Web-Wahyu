<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryTransaksi extends Model
{
    use HasFactory;

    protected $table = 'history_transaksi';

    protected $fillable = [
        'transaksi_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi_sebelumnya',
        'durasi_baru',
        'perbedaan_harga',
        'bukti_pembayaran',
        'status'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
