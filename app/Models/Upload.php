<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage; // Important for URL generation

class Upload extends Model
{
    use HasFactory;

    // ⚠️ CRITICAL: Must match your migration table name
    protected $table = 'upload'; 

    protected $fillable = [
        'uploaded_image',
        'captured_image',
    ];

    // Accessor for ViewUploadResource to correctly display uploaded image
    public function getUploadedImageUrlAttribute(): ?string
    {
        return $this->uploaded_image ? Storage::url($this->uploaded_image) : null;
    }

    // Accessor for ViewUploadResource to correctly display captured image
    public function getCapturedImageUrlAttribute(): ?string
    {
        return $this->captured_image ? Storage::url($this->captured_image) : null;
    }

    // Computed attribute for custom table column
    public function getImagesAttribute(): array
    {
        return [
            'uploaded' => $this->getUploadedImageUrlAttribute(),
            'captured' => $this->getCapturedImageUrlAttribute(),
        ];
    }
}