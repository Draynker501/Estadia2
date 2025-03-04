<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectChecklist;
use App\Models\ProjectProjectChecklist;
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
                                $clientId = $get('client_id');
                                $projectId = $get('id');
                                $exists = Project::where('client_id', $clientId)
                                    ->where('name', $value)
                                    ->where('id', '!=', $projectId)
                                    ->exists();

                                if ($exists) {
                                    $fail('Ya existe un proyecto con este nombre para el cliente seleccionado.');
                                }
                            };
                        },
                    ]),
                Forms\Components\Select::make('client_id')
                    ->relationship('client', 'name') // Relación con el modelo Customer
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
                    ->relationship('projectProjectChecklists')
                    ->schema([
                        Forms\Components\Select::make('project_checklist_id')
                            ->relationship('projectChecklist', 'task')
                            ->required()
                            ->label('Task')
                            ->placeholder('Select a task'),
                    ])
                    ->orderable(column: 'orden')
                    ->defaultItems(1)
                    ->minItems(1)
                    ->collapsible()
                    ->itemLabel(fn($state) => isset($state['project_checklist_id'])
                        ? ProjectChecklist::find($state['project_checklist_id'])?->task ?? 'Nueva tarea'
                        : 'Nueva tarea'),
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
                Tables\Columns\TextColumn::make('client.name')
                    ->label('Client')
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
    protected static function updateProjectChecklistCheck($checklists, $projectId)
    {
        foreach ($checklists as $checklistData) {
            $originalChecklist = ProjectChecklist::find($checklistData['project_checklist_id']);

            if ($originalChecklist) {
                $duplicatedChecklist = $originalChecklist->replicate();
                $duplicatedChecklist->is_cloned = $originalChecklist->is_cloned; // Nuevo campo
                $duplicatedChecklist->save();

                $projectProjectChecklist = new ProjectProjectChecklist();
                $projectProjectChecklist->project_id = $projectId;
                $projectProjectChecklist->project_checklist_id = $duplicatedChecklist->id;
                $projectProjectChecklist->save();

                foreach ($originalChecklist->projectChecks as $check) {
                    $duplicatedCheck = $check->replicate();
                    $duplicatedCheck->project_checklist_id = $duplicatedChecklist->id;
                    $duplicatedCheck->save();

                    ProjectChecklistCheck::create([
                        'project_project_checklist_id' => $projectProjectChecklist->id,
                        'project_check_id' => $duplicatedCheck->id,
                        'checked' => false,
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
