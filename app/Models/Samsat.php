<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Samsat extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'samsat';

    /**
     * Atribut yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'mobil_id',
        'keterangan',
        'biaya',
        'bukti_pembayaran'
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
}
