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

class CustomerResource extends Resource
{
    //Define el modelo al que corresponde el recurso
    protected static ?string $model = Customer::class;

    //Define el ícono de navegación del recurso (Lateral izquierdo)
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    //Hace referencia al formulario de customer (create y editar)
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(20),
                Forms\Components\TextInput::make('last_name')
                    ->required()
                    ->maxLength(30),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->minLength(10)
                    ->maxLength(15),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(50),
                Forms\Components\Toggle::make('status') // Cambiar Select por Toggle
                    ->label('Estado')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(true) // 1 como valor predeterminado
                    ->required(),
            ]);
    }

    //Define la tabla donde se muestran los datos de los customers (index)
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('last_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable()
                    ->formatStateUsing(function ($state) {
                        // Si el teléfono no empieza con "+" lo agregamos
                        return $state && !str_starts_with($state, '+') ? '+' . $state : $state;
                    }),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Estado')
                    ->formatStateUsing(function ($state) {
                        return $state ? 'Activo' : 'Inactivo';
                    })
                    ->colors([
                        'success' => fn($state): bool => $state, // Verde para Activo
                        'danger' => fn($state): bool => !$state, // Rojo para Inactivo
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->query(function (Builder $query) {
                return Customer::query()->filterByAuthor();
            });
    }

    //Define las relaciones de customers (No fueron necesarias en este caso)
    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    //Define las vistas relacionadas a customers
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
