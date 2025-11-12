<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $table = 'invoice';
    public function faktur() {
        return $this->belongsTo(Faktur::class, 'faktur_id');
    }
    public function barang() {
        return $this->belongsTo(Barang::class);
    }
}
