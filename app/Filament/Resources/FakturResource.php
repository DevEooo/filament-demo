<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FakturResource\Pages;
use App\Filament\Resources\FakturResource\RelationManagers;
use App\Models\Faktur;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\Repeater;

class FakturResource extends Resource
{
    protected static ?string $model = Faktur::class;
    protected static ?string $navigationLabel = 'Faktur';
    protected static ?string $slug = "faktur";
    protected static ?string $label = "Faktur Barang";

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('kode_faktur')
                    ->columnSpan(2),
                TextInput::make('kode_customer')
                    ->numeric(),
                Select::make('customer_id')
                    ->relationship(name: 'customer', titleAttribute: 'nama_customer'),
                Repeater::make('invoice')
                    ->relationship()
                    ->schema([
                        Select::make('barang_id')
                            ->relationship(name: 'barang', titleAttribute: 'nama_barang'),
                        TextInput::make('diskon')
                            ->numeric(),
                        TextInput::make('nama_barang'),
                        TextInput::make('qty')
                            ->numeric(),
                        TextInput::make('harga')
                            ->numeric(),
                        TextInput::make('subtotal')
                            ->numeric(),
                        TextInput::make('hasil_qty')
                            ->numeric()
                    ]),
                TextInput::make('total')    
                    ->numeric(),
                TextInput::make('charge')
                    ->numeric(),
                TextInput::make('nominal_charge')
                    ->columnSpan(2)
                    ->numeric(),
                TextInput::make('total_final')
                    ->numeric(),
                DatePicker::make('tanggal_faktur'),
                TextInput::make('ket_faktur'),
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('kode_faktur'),
                TextColumn::make('kode_customer'),
                TextColumn::make('customer_id'),
                TextColumn::make('total'),
                TextColumn::make('charge'),
                TextColumn::make('nominal_charge'),
                TextColumn::make('total_final'),
                TextColumn::make('tanggal_faktur'),
                TextColumn::make('ket_faktur')
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListFakturs::route('/'),
            'create' => Pages\CreateFaktur::route('/create'),
            'edit' => Pages\EditFaktur::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
