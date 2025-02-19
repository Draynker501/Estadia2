<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectChecklist;
use App\Models\ProjectChecklistCheck;
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
                    ->relationship('projectChecklistRels')
                    ->schema([
                        Forms\Components\Select::make('project_checklist_id') // El campo select para elegir un checklist
                            ->relationship('projectChecklist', 'task') // Relación con el modelo Checklist
                            ->required()
                            ->label('Task')
                            ->placeholder('Select a task'),
                    ])
                    ->orderable(column: 'orden') // Habilitar la funcionalidad de ordenamiento
                    ->defaultItems(1) // Número de items por defecto en el repeater
                    ->minItems(1) // Mínimo de items requeridos
                    ->collapsible() // Permite colapsar los pasos para mejor visualización
                    ->itemLabel(fn($state) => isset($state['project_checklist_id']) ? ProjectChecklist::find($state['project_checklist_id'])?->task ?? 'Nueva tarea' : 'Nueva tarea')
                    ->afterStateUpdated(fn($state, $set) => self::updateProjectChecklistCheck($state)), // Llama a la función para actualizar los estados
                Forms\Components\Repeater::make('notes')
                    ->relationship('notes')
                    ->schema([
                        Forms\Components\Textarea::make('content')
                            ->label('Nota')
                            ->rows(3),
                    ])
                    ->columnSpanFull()
                    ->default([])
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

    protected static function updateProjectChecklistCheck($state)
    {
        foreach ($state as $checklistData) {
            // Asegúrate de que la ID esté disponible antes de intentar acceder a ella
            $projectChecklist = ProjectChecklist::find($checklistData['project_checklist_id']);

            if ($projectChecklist && isset($checklistData['id'])) {
                // Crea un registro en check_status para cada check dentro del checklist
                foreach ($projectChecklist->projectChecks as $projectCheck) {
                    ProjectChecklistCheck::firstOrCreate([
                        'project_checklist_rel_id' => $checklistData['id'], // Asegúrate de usar el ID correcto de project_checklist
                        'project_check_id' => $projectCheck->id,
                        'checked' => false, // Estado por defecto, puedes cambiarlo según lo que necesites
                    ]);
                }
            }
        }
    }



    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record:slug}/edit'),
        ];
    }
}
