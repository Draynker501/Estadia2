<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'path', 'mime'];

    protected static function booted()
    {
        // Eliminar archivo al borrar el registro
        static::deleting(function ($file) {
            if ($file->path) {
                Storage::disk('public')->delete($file->path);
            }
        });

        // Reemplazar archivo al actualizar el registro
        static::updating(function ($file) {
            if ($file->isDirty('path')) { // Verifica si el archivo ha cambiado
                Storage::disk('public')->delete($file->getOriginal('path')); // Borra el archivo anterior
            }
        });

        static::saving(function ($file) {
            if ($file->path) {
                $file->mime = pathinfo($file->path, PATHINFO_EXTENSION);
            }
        });
    }

    public function download()
    {
        $filePath = 'public/' . $this->path;

        if (!Storage::exists($filePath)) {
            abort(404, 'Archivo no encontrado.');
        }

        $mimeType = Storage::mimeType($filePath);
        $fileName = $this->name . '.' . pathinfo($this->path, PATHINFO_EXTENSION);

        return response()->streamDownload(function () use ($filePath) {
            echo Storage::get($filePath);
        }, $fileName, [
            'Content-Type' => $mimeType,
        ]);
    }

    public function setPathAttribute($value)
    {
        $this->attributes['path'] = pathinfo($value, PATHINFO_BASENAME);
    }

    public function getPathAttribute($value)
    {
        return 'files/' . $value; // This ensures that when retrieving, it includes 'files/'
    }
}
