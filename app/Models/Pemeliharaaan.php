<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeliharaaan extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'pemeliharaan';

    /**
     * Atribut yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'mobil_id',
        'keterangan',
        'biaya',
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
