<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UploadResource\Pages;
use App\Filament\Resources\UploadResource\RelationManagers;
use App\Models\Upload;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\HtmlString;
use App\Filament\Forms\Components\CameraCapture;

class UploadResource extends Resource
{
    protected static ?string $model = Upload::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Upload Gambar';
    protected static ?string $slug = "upload-gambar";
    protected static ?string $label = "Upload Gambar";

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('uploaded_image')
                    ->label('Upload Gambar')
                    ->image()
                    ->imageEditor()
                    ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
                    ->maxSize(2048)
                    ->directory('uploads/uploaded')
                    ->visibility('public')
                    ->columnSpanFull(),
                CameraCapture::make('captured_image')
                    ->label('Ambil Gambar')
                    ->columnSpanFull(),
            ]);
    }



    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateUpload::route('/'),
        ];
    }
}
