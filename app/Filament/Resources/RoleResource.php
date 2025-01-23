<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RoleResource\Pages;
use App\Filament\Resources\RoleResource\RelationManagers;

use App\Models\Role;
use Filament\Forms;
use Filament\Forms\Components\Card;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RoleResource extends Resource
{
    protected static ?string $model = Role::class;

    protected static ?string $navigationIcon = 'heroicon-o-finger-print';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->minLength(2)
                        ->maxLength(255)
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->placeholder('Name'),
                    Forms\Components\CheckboxList::make('permissions')
                        ->relationship('permissions', 'name')  // Asocia los permisos con el campo 'permissions' en el modelo
                        ->required() // Si quieres que los permisos sean obligatorios
                        ->columns(3) // Opcional, para mostrar los checkboxes en varias columnas
                        ->default(fn($get) => $get('permissions') ?? []), // Establecer valores predeterminados si es necesario
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListRoles::route('/'),
            'create' => Pages\CreateRole::route('/create'),
            'edit' => Pages\EditRole::route('/{record}/edit'),
            // 'view' => Pages\ViewRole::route('/{record}'),
        ];
    }

    //Define la consulta de roles que se muestran en el index (con un filtro para que no se muestre el rol Super Admin)
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();

        // Verifica si el usuario logueado tiene el rol 'Super Admin'
        if (!auth()->user()->hasRole('Super Admin')) {
            // Excluye el rol 'Super Admin' para usuarios que no sean Super Admin
            $query->where('name', '!=', 'Super Admin');
        }

        return $query;
    }
}
