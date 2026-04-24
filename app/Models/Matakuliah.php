<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Jurusan;

class Matakuliah extends Model
{
    protected $table = 'tb_matakuliah';
    protected $primaryKey = 'id_matakuliah';

    protected $fillable = [
        'nama_matakuliah',
        'sks',
        'id_jurusan'
    ];

    // Relasi ke Jurusan , 1 matakuliah 1 jurusan
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'id_jurusan', 'id_jurusan');
    }
}
