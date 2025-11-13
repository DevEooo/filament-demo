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
use App\Models\Customer;
use App\Models\Barang;
use Filament\Forms\Set;
use Filament\Forms\Get;

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
                    ->numeric()
                    ->reactive(),
                Select::make('customer_id')
                    ->relationship(name: 'customer', titleAttribute: 'nama_customer')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $cust = Customer::find($state);

                        if ($cust) {
                            $set('kode_customer', $cust->id);
                        }
                    })
                    ->afterStateHydrated(function ($state, callable $set) {
                        $cust = Customer::find($state);

                        if ($cust) {
                            $set('kode_customer', $cust->id);
                        }
                    }),
                Repeater::make('invoice')
                    ->relationship()
                    ->schema([
                        Select::make('barang_id')
                            ->relationship(name: 'barang', titleAttribute: 'nama_barang')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                $barang = Barang::find($state);

                                if ($barang) {
                                    $set('nama_barang', $barang->nama_barang);
                                    $set('harga', $barang->harga);
                                }
                            }),
                        TextInput::make('diskon')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $qtyTotal = $get('hasil_qty');
                                $disc = $qtyTotal * ($state / 100);
                                $total = $qtyTotal - $disc;

                                $set('subtotal', intval($total));
                            })
                            ->suffix('%')
                            ->label('Diskon (%)'),
                        TextInput::make('nama_barang')
                            ->reactive(),
                        TextInput::make('qty')
                            ->numeric()
                            ->reactive()
                            ->afterStateUpdated(function (Set $set, $state, Get $get) {
                                $fixedPrice = $get('harga');
                                $set('hasil_qty', $state * $fixedPrice);
                            }),
                        TextInput::make('harga')
                            ->numeric()
                            ->disabled()
                            ->reactive()
                            ->prefix('Rp. '),
                        TextInput::make('subtotal')
                            ->numeric()
                            ->reactive()
                            ->disabled(),
                        TextInput::make('hasil_qty')
                            ->numeric()
                            ->disabled()
                            ->reactive(),
                    ]),
                TextInput::make('total')
                    ->numeric()
                    ->placeholder(function (Set $set, Get $get) {
                        $invoice = collect($get('invoice'))->pluck('subtotal')->sum();
                        if ($invoice == null) {
                            $set('total', 0);
                        } else {
                            $set('total', $invoice);
                        }
                    }),
                TextInput::make('charge')
                    ->numeric(),
                TextInput::make('nominal_charge')
                    ->columnSpan(2)
                    ->numeric()
                    ->reactive()
                    ->suffix('%')
                    ->label('Charge (%)')
                    ->afterStateUpdated(function (Set $set, $state, Get $get) {
                        $total = $get('total');
                        $final = $total * ($state / 100);
                        $result = $total + $final;

                        $set('total_final', $result);
                        $set('charge', $final);
                    }),
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
                TextColumn::make('customer.nama_customer'),
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
