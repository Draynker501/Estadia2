<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChecklistResource\Pages;
use App\Filament\Resources\ChecklistResource\RelationManagers;
use App\Models\Checklist;
use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChecklistResource extends Resource
{
    protected static ?string $model = Checklist::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function getNavigationGroup(): ?string
    {
        return 'Administración';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('task')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Repeater::make('check')
                    ->relationship('checks') // Relación con ProjectStep
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(150),
                        Forms\Components\Toggle::make('required')
                            ->default(false)
                            ->required()
                    ])
                    ->minItems(1) // Mínimo 1 paso requerido
                    ->collapsible()
                    ->itemLabel(fn ($state) => $state['name'] ?? 'Nuevo paso'), // Muestra el nombre en el título
                Forms\Components\Repeater::make('notes')
                    ->relationship('notes')
                    ->schema([
                        Forms\Components\Textarea::make('content')
                            ->label('Nota')
                            ->rows(3),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->default([])
                    ->itemLabel(fn ($state) => isset($state['content']) ? Str::limit($state['content'], 30) : 'Nueva nota'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('task')
                    ->searchable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListChecklists::route('/'),
            'create' => Pages\CreateChecklist::route('/create'),
            'edit' => Pages\EditChecklist::route('/{record}/edit'),
        ];
    }
}
