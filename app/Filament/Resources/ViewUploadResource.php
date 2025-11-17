<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ViewUploadResource\Pages;
use App\Filament\Resources\ViewUploadResource\RelationManagers;
use App\Models\Upload; // Make sure this is imported
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;
use App\Filament\Resources\ViewUploadResource\Pages\EditViewUpload;

class ViewUploadResource extends Resource
{
    // ⚠️ CORRECTED: Must point to your existing Upload model
    protected static ?string $model = Upload::class;

    // Add Navigation Labels for clarity
    protected static ?string $navigationIcon = 'heroicon-o-eye';
    protected static ?string $navigationLabel = 'Lihat Data Upload';
    protected static ?string $slug = "view-upload-data";
    protected static ?string $navigationGroup = 'Kelola';


    public static function form(Form $form): Form
    {
        // No form needed for view-only resource
        return $form;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ViewColumn::make('images')
                    ->label('Gambar')
                    ->view('filament.tables.columns.upload-images')
                    ->state(function ($record) {
                        return [
                            'uploaded' => $record->uploaded_image_url,
                            'captured' => $record->captured_image_url,
                        ];
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Upload')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('download_uploaded')
                    ->label('Download Uploaded')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return response()->download(storage_path('app/public/' . $record->uploaded_image));
                    })
                    ->visible(fn ($record) => !empty($record->uploaded_image)),
                Tables\Actions\Action::make('download_captured')
                    ->label('Download Captured')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function ($record) {
                        return response()->download(storage_path('app/public/' . $record->captured_image));
                    })
                    ->visible(fn ($record) => !empty($record->captured_image)),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->headerActions([
                //
            ]);
    }
    // ... rest of the class methods (getRelations, getPages) remain mostly the same
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListViewUploads::route('/'),
            'view' => Pages\EditViewUpload::route('/{record}'),
        ];
    }
}
