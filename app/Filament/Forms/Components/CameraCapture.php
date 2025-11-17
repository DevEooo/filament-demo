<?php

namespace App\Filament\Forms\Components;

use Filament\Forms\Components\Field;
use Illuminate\Support\Facades\Storage;

// We use the Field class to define our custom Filament form component
class CameraCapture extends Field
{
    protected string $view = 'filament.forms.components.camera-capture';


}