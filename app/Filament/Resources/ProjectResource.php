<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\Checklist;
use Illuminate\Support\Str;
use Filament\Actions\DeleteAction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 2;

    public static function getNavigationGroup(): ?string
    {
        return 'Administración';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(150)
                    ->rules([
                        function ($get) {
                            return function (string $attribute, $value, $fail) use ($get) {
                                $customerId = $get('customer_id');
                                $projectId = $get('id');
                                $exists = Project::where('customer_id', $customerId)
                                    ->where('name', $value)
                                    ->where('id', '!=', $projectId)
                                    ->exists();

                                if ($exists) {
                                    $fail('Ya existe un proyecto con este nombre para el cliente seleccionado.');
                                }
                            };
                        },
                    ]),
                Forms\Components\Select::make('customer_id')
                    ->relationship('customer', 'name') // Relación con el modelo Customer
                    ->required(),
                Forms\Components\RichEditor::make('description') //RichEditor permite dar formato al texto
                    ->required()
                    ->toolbarButtons([
                        'bold', // Botón de negrita
                        'italic', // Botón de cursiva
                        'underline', // Botón de subrayado
                        'strike', // Botón de tachado
                    ]),
                Forms\Components\Repeater::make('projectChecklists')
                    ->relationship('projectChecklists')
                    ->schema([
                        Forms\Components\Select::make('checklist_id') // El campo select para elegir un checklist
                            ->relationship('checklist', 'task') // Relación con el modelo Checklist
                            ->required()
                            ->label('Task')
                            ->placeholder('Select a task'),
                    ])
                    ->orderable(column: 'orden') // Habilitar la funcionalidad de ordenamiento
                    ->defaultItems(1) // Número de items por defecto en el repeater
                    ->minItems(1) // Mínimo de items requeridos
                    ->collapsible() // Permite colapsar los pasos para mejor visualización
                    ->itemLabel(fn($state) => isset($state['checklist_id']) ? Checklist::find($state['checklist_id'])?->task ?? 'Nueva tarea' : 'Nueva tarea'),

                Forms\Components\Repeater::make('notes')
                    ->relationship('notes')
                    ->schema([
                        Forms\Components\Textarea::make('content')
                            ->label('Nota')
                            ->rows(3)
                            ->required(),
                    ])
                    ->columnSpanFull()
                    ->collapsible()
                    ->itemLabel(fn($state) => isset($state['content']) ? Str::limit($state['content'], 30) : 'Nueva nota'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->label('Customer')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('revisar')
                    ->label('Revisar')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Project $record) => ProjectResource::getUrl('review', ['record' => $record->id])),
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
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
            'review' => Pages\ReviewProject::route('/{record}/review'),
        ];
    }
}
