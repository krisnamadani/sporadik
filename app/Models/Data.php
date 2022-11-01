<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data extends Model
{
    use HasFactory;

    protected $table = 'data';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jenis_kegiatan()
    {
        return $this->belongsTo(JenisKegiatan::class);
    }

    public function hasil_pekerjaan()
    {
        return $this->hasMany(HasilPekerjaan::class);
    }

    public function sertipikat()
    {
        return $this->hasMany(Sertipikat::class);
    }
}
