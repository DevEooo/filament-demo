<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Filament\Resources\BarangResource\RelationManagers;
use App\Models\Barang;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;
    protected static ?string $navigationLabel = 'Kelola Barang';
    protected static ?string $navigationGroup = 'Kelola';
    protected static ?string $navigationIcon = "heroicon-s-user";
    protected static ?string $slug = "kelola-barang";
    protected static ?string $label = "Kelola Barang";


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_barang')
                    ->columnSpan(2),
                TextInput::make('kode_barang'),
                TextInput::make('jumlah')
                    ->numeric(),
                TextInput::make('harga')
                    ->columnSpan(2)
                    ->numeric(),
                Select::make('jenis')
                    ->options([
                        'Makanan' => 'Makanan',
                        'Minuman' => 'Minuman'
                    ])
                    ->columnSpan(2)
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_barang')
                    ->searchable(),
                TextColumn::make('kode_barang')
                    ->searchable(),
                TextColumn::make('jumlah'),
                TextColumn::make('harga'),
                TextColumn::make('jenis')
                    ->searchable()
                    ->hidden()
                    ->sortable(),
            ])
            ->filters([
                Filter::make('Makanan')
                    ->query(fn(Builder $query) => $query->where('jenis', true)),
                Filter::make('Minuman')
                    ->query(fn(Builder $query) => $query->where('jenis', true)),
                SelectFilter::make('jenis')
                    ->options([
                        'Makanan' => 'Makanan',
                        'Minuman' => 'Minuman'
                    ]),
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
            'index' => Pages\ListBarangs::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
