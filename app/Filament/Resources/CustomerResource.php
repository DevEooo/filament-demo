<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;
    protected static ?string $navigationLabel = 'Kelola Customer';
     protected static ?string $navigationGroup = 'Kelola';
    protected static ?string $navigationIcon = 'heroicon-s-user';
    protected static ?string $slug = "kelola-customer";
    protected static ?string $label = "Kelola Customer";
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_customer')
                    ->columnSpan(2)
                    ->label('Nama')
                    ->placeholder('Masukan Nama Customer'),
                TextInput::make('no_telp')
                    ->numeric()
                    ->label('Nomor Telepon')
                    ->placeholder('Masukan Nomor Telepon'),
                TextInput::make('email')
                    ->email()
                    ->suffix('.com')
                    ->placeholder('Masukan Email'),
                TextInput::make('alamat')
                    ->columnSpan(2)
                    ->placeholder('Masukan Alamat')
            ])
            ->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_customer')
                    ->searchable(),
                TextColumn::make('no_telp')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('alamat')

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
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
