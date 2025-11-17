<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ViewUploadResource\Pages;
use App\Models\Upload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class ViewUploadResource extends Resource
{
    protected static ?string $model = Upload::class;
    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationLabel = 'Lihat Data Upload (Tabel)';
    protected static ?string $slug = "view-upload-data";
    protected static ?string $navigationGroup = 'Kelola Gambar';

    public static function form(Form $form): Form
    {
        // No form needed for list view
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('uploaded_image')
                    ->label('Gambar Upload (File)')
                    ->disk('public')
                    ->height(60)
                    ->width(60),

                Tables\Columns\ImageColumn::make('captured_image')
                    ->label('Gambar Ambil (Kamera)')
                    ->disk('public')
                    ->height(60)
                    ->width(60),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Upload')
                    ->sortable()
                    ->dateTime(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                
                Tables\Actions\Action::make('download_uploaded')
                    ->label('Download File')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('success')
                    ->action(fn ($record) => Storage::download($record->uploaded_image))
                    ->visible(fn ($record) => !empty($record->uploaded_image)),
                    
                Tables\Actions\Action::make('download_captured')
                    ->label('Download Kamera')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->color('info')
                    ->action(fn ($record) => Storage::download($record->captured_image))
                    ->visible(fn ($record) => !empty($record->captured_image)),
                
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                // Add a button to easily navigate to the Upload form
                Tables\Actions\Action::make('new_upload')
                    ->label('Upload Gambar Baru')
                    ->icon('heroicon-o-plus')
                    ->button()
                    ->url(fn (): string => UploadResource::getUrl('index'))
            ]);
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListViewUploads::route('/'),
            'view' => Pages\ViewViewUpload::route('/{record}'),
        ];
    }
    
    // Disable creation in this resource, it's handled by UploadResource
    public static function canCreate(): bool { return false; }

}