<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UploadResource\Pages;
use App\Models\Upload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Forms\Components\FileUpload;
use App\Filament\Forms\Components\CameraCapture;

class UploadResource extends Resource
{
    protected static ?string $model = Upload::class;
    protected static ?string $navigationIcon = 'heroicon-o-camera';
    protected static ?string $navigationLabel = 'Upload Gambar (Form)';
    protected static ?string $slug = "upload-gambar";
    protected static ?string $navigationGroup = 'Kelola Gambar';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('uploaded_image')
                    ->label('1. Upload Gambar (Pilih File)')
                    ->helperText('Gunakan ini untuk mengunggah gambar yang sudah ada.')
                    ->image()
                    ->imageEditor()
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->maxSize(2048)
                    ->directory('uploads/uploaded')
                    ->visibility('public')
                    ->columnSpanFull(),

                CameraCapture::make('captured_image') 
                    ->label('2. Ambil Gambar (Kamera)')
                    ->helperText('Gunakan ini untuk mengambil gambar langsung dengan kamera Anda.')
                    ->columnSpanFull(),
            ]);
    }

    // This resource only needs the Create page
    public static function getPages(): array
    {
        return [
            'index' => Pages\CreateUpload::route('/'),
        ];
    }
    
    // Disable other unnecessary functionalities
    public static function canViewAny(): bool { return true; } 
    public static function canEdit($record): bool { return false; }
    public static function canDelete($record): bool { return false; }
    public static function canView($record): bool { return false; }
    
    // Remove the table and relations methods if they only return empty arrays/null
    public static function getRelations(): array { return []; }
    public static function table(\Filament\Tables\Table $table): \Filament\Tables\Table { return $table; }
}