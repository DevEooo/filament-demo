<?php

namespace App\Filament\Resources\UploadResource\Pages;

use App\Filament\Resources\UploadResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Storage;

class CreateUpload extends CreateRecord
{
    protected static string $resource = UploadResource::class;

    // Redirect to the ViewUploadResource after creation
    protected function getRedirectUrl(): string
    {
        return route('filament.admin.resources.view-upload-data.index');
    }

    public function saveFile(string $base64Data, string $filename = null): string
    {
        // 1. Decode the base64 data
        $data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64Data));

        // 2. Set storage path
        $dir = 'uploads/captured';
        $filename = $filename ?? time() . '-' . uniqid() . '.png';
        $path = $dir . '/' . $filename;

        // 3. Save the file to public disk
        Storage::disk('public')->put($path, $data);

        // 4. Return the file path (this is what gets saved in the DB)
        return $path;
    }
}
