<?php

namespace App\Filament\Resources\ViewUploadResource\Pages;

use App\Filament\Resources\ViewUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class EditViewUpload extends ViewRecord
{
    protected static string $resource = ViewUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No edit action for view-only resource
        ];
    }
}
