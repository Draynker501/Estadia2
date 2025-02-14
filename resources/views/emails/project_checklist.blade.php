<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist del Proyecto</title>
</head>
<body>
    <p>Hola,</p>
    <p>Adjunto encontrarás el checklist del proyecto <strong>{{ $record->name }}</strong>.</p>
    {{-- <a href="{{ route('project-checklist.pdf', $record->id) }}" target="_blank">Descargar checklist en PDF</a> --}}
    <p>Saludos,</p>
    <p>Tu equipo</p>
</body>
</html>
