<?php
namespace App\Filament\Resources\ViewUploadResource\Pages;
use App\Filament\Resources\ViewUploadResource;
use Filament\Resources\Pages\ListRecords;
class ListViewUploads extends ListRecords
{
    protected static string $resource = ViewUploadResource::class;
}

// app/Filament/Resources/ViewUploadResource/Pages/ViewViewUpload.php
namespace App\Filament\Resources\ViewUploadResource\Pages;
use App\Filament\Resources\ViewUploadResource;
use Filament\Resources\Pages\ViewRecord;
class ViewViewUpload extends ViewRecord
{
    protected static string $resource = ViewUploadResource::class;
}