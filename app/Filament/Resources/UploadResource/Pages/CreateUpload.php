<?php

namespace App\Filament\Resources\UploadResource\Pages;

use App\Filament\Resources\UploadResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUpload extends CreateRecord
{
    protected static string $resource = UploadResource::class;

    public function getTitle(): string
    {
        return 'Upload Gambar';
    }

    protected function getFormActions(): array
    {
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction(),
        ];
    }

    protected function getCreateFormAction(): Actions\Action
    {
        return parent::getCreateFormAction()
            ->label('Simpan');
    }

    protected function getCancelFormAction(): Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('Batal');
    }
}
