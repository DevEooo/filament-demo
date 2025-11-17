<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upload extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'upload';

    protected $appends = ['uploaded_image_url', 'captured_image_url'];

    public function getUploadedImageUrlAttribute()
    {
        return $this->uploaded_image ? asset('storage/' . $this->uploaded_image) : null;
    }

    public function getCapturedImageUrlAttribute()
    {
        return $this->captured_image ? asset('storage/' . $this->captured_image) : null;
    }
}
