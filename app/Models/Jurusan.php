<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

class Jurusan extends Model
{
    protected $table = 'tb_jurusan';
    protected $primaryKey = 'id_jurusan';

    protected $fillable = [
        'nama_jurusan',
        'akreditasi'
    ];

    // Relasi ke Mahasiswa
    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'id_jurusan', 'id_jurusan');
    }

    // Relasi ke Matakuliah
    public function matakuliahs(): HasMany
    {
        return $this->hasMany(Matakuliah::class, 'id_jurusan', 'id_jurusan');
    }
}