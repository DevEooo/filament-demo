<?php

namespace App\Filament\Resources\ViewUploadResource\Pages;

use App\Filament\Resources\ViewUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListViewUploads extends ListRecords
{
    protected static string $resource = ViewUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // No create action for view-only resource
        ];
    }
}
