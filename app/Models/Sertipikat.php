<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sertipikat extends Model
{
    use HasFactory;

    protected $table = 'sertipikat';
    protected $guarded = ['id'];

    public function data()
    {
        return $this->belongsTo(Data::class);
    }
}
