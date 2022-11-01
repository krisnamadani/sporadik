<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPekerjaan extends Model
{
    use HasFactory;

    protected $table = 'hasil_pekerjaan';
    protected $guarded = ['id'];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
