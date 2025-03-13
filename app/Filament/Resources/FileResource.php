<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FileResource\Pages;
use App\Filament\Resources\FileResource\RelationManagers;
use App\Models\File;
use Auth;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Storage;

class FileResource extends Resource
{
    protected static ?string $model = File::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    public static function getNavigationGroup(): ?string
    {
        return 'Administración';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Name')
                    ->required(),
                Forms\Components\FileUpload::make('path')
                    ->label('File')
                    ->disk('public')
                    ->directory('files')
                    ->visibility('public')
                    ->image()
                    ->required()
                    ->maxSize(2048)
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if (request()->hasFile('path') && request()->file('path')->getSize() > 2097152) { // 2MB en bytes
                            $set('path', null); // Limpia el archivo
                            throw \Filament\Notifications\Notification::make()
                                ->title('Error')
                                ->body('El archivo es demasiado grande. El tamaño máximo permitido es de 2MB.')
                                ->danger()
                                ->send();
                        }
                    })
                    // Método para guardar el archivo con un nombre personalizado
                    ->saveUploadedFileUsing(function ($file, $state) {
                        $userId = Auth::id();
                        $fileId = File::max('id') + 1; // Siguiente ID estimado
                        $extension = $file->getClientOriginalExtension(); // Extensión del archivo
            
                        $customFileName = "{$userId}_file_{$fileId}." . $extension; // Nombre personalizado del archivo
            
                        // Guardar el archivo con el nombre personalizado
                        $path = Storage::disk('public')->putFileAs('files', $file, $customFileName);

                        return pathinfo($path, PATHINFO_BASENAME); // Guarda solo el nombre del archivo en la base de datos
                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nombre'),
                Tables\Columns\IconColumn::make('path')
                    ->label('Archivo')
                    ->icon('heroicon-o-photo') // Generic image icon
                    ->color('primary'),
                Tables\Columns\TextColumn::make('mime')
                    ->label('Extensión')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('download')
                    ->label('Descargar')
                    ->icon('heroicon-m-arrow-down-tray')
                    ->url(fn(File $record) => route('files.download', $record))
                    ->openUrlInNewTab(false) // No abre una nueva pestaña
                    ->color('secondary')
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
            'index' => Pages\ListFiles::route('/'),
            'create' => Pages\CreateFile::route('/create'),
            'edit' => Pages\EditFile::route('/{record}/edit'),
        ];
    }
}
