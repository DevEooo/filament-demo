<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CameraCapture extends Field
{

    protected string $view = 'filament.forms.components.camera-capture';
    protected string $diskName = 'public';
    protected string $directory = 'uploads/captured';
    protected int $maxSize = 2048;
    protected array $acceptedFileTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];

    public function disk(string $diskName): static
    {
        $this->diskName = $diskName;
        return $this;
    }

    public function directory(string $directory): static
    {
        $this->directory = $directory;
        return $this;
    }

    public function maxSize(int $maxSize): static
    {
        $this->maxSize = $maxSize;
        return $this;
    }

    public function acceptedFileTypes(array $types): static
    {
        $this->acceptedFileTypes = $types;
        return $this;
    }

    public function getDiskName(): string
    {
        return $this->diskName;
    }

    public function getDirectory(): string
    {
        return $this->directory;
    }

    public function getMaxSize(): int
    {
        return $this->maxSize;
    }

    public function getAcceptedFileTypes(): array
    {
        return $this->acceptedFileTypes;
    }

    public function saveUploadedFile($file)
    {
        if (!$file) return null;

        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($this->directory, $filename, $this->diskName);

        return $path;
    }


}
