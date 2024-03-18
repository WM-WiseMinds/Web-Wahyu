<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;

    /**
     * Nama tabel
     *
     * @var string
     */
    protected $table = 'pelanggan';

    /**
     * Atribut yang dapat diisi
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'alamat',
        'no_hp',
    ];

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
     * Relasi ke tabel Penyewaan
     *
     * @return void
     */
    public function penyewaan()
    {
        return $this->hasMany(Penyewaan::class);
    }
}
