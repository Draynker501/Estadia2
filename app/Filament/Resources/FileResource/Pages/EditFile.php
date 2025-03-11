<?php

namespace App\Filament\Resources\FileResource\Pages;

use App\Filament\Resources\FileResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EditFile extends EditRecord
{
    protected static string $resource = FileResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\Action::make('downloadWebp')
                ->label('Descargar en WebP')
                ->icon('heroicon-m-arrow-down-tray')
                ->action(function () {
                    return $this->downloadWebp($this->record);
                })
                ->openUrlInNewTab(false)
                ->color('success'),
        ];
    }

    protected function downloadWebp($file): StreamedResponse
    {
        // Obtener la ruta correcta del archivo desde el disco público
        $filePath = Storage::disk('public')->path("{$file->path}");

        // Verificar si el archivo existe
        if (!file_exists($filePath)) {
            abort(404, "El archivo no existe: {$filePath}");
        }

        // Convertir la imagen a WebP con Intervention Image
        $image = Image::make($filePath)->encode('webp', 90); // Calidad 90%

        // Nombre del archivo convertido
        $webpFileName = pathinfo($file->path, PATHINFO_FILENAME) . '.webp';

        // Generar respuesta de descarga
        return response()->streamDownload(function () use ($image) {
            echo $image;
        }, $webpFileName, [
            'Content-Type' => 'image/webp',
        ]);
    }
}
