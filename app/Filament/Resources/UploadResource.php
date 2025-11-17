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
                \emmanpbarrameda\FilamentTakePictureField\Forms\Components\TakePicture::make('captured_image')
                    ->label('Ambil Foto')
                    ->disk('public')
                    ->directory('uploads/captured')
                    ->visibility('public')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('uploaded_image')
                    ->label('Gambar Upload')
                    ->height(100)
                    ->width(100)
                    ->disk('public'),
                ImageColumn::make('captured_image')
                    ->label('Foto Kamera')
                    ->height(100)
                    ->width(100)
                    ->disk('public'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat Pada')
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'create' => Pages\CreateUpload::route('/create'),
            'edit' => Pages\EditUpload::route('/{record}/edit'),
        ];
    }
}
