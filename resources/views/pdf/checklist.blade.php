<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .container {
            width: 100%;
            margin: 0 auto;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
            text-align: center;
        }

        .task {
            border-bottom: 1px solid #ddd;
            padding: 5px 0;
        }

        .completed {
            color: green;
            font-weight: bold;
        }

        .pending {
            color: red;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="title">{{ $record->name }} - Checklist</h2>

        @foreach ($checklists as $checklist)
            <div class="task">
                <h3>{{ $checklist['task'] }}</h3>
                {{-- <p>Estado: 
                    <span class="{{ $checklist['completed'] ? 'completed' : 'pending' }}">
                        {{ $checklist['completed'] ? 'Completado' : 'Pendiente' }}
                    </span>
                </p> --}}
                <h4>Checks:</h4>
                <ul>
                    @foreach ($checklist['checks'] as $check)
                        <li style="list-style-type: none;">
                            {{-- Casilla de verificación con alineación vertical ajustada --}}
                            <input type="checkbox" {{ $check['checked'] ? 'checked' : '' }} disabled
                                style="vertical-align: middle;">
                            {{ $check['name'] }}
                            @if ($check['required'])
                                <span class="text-red-500 font-bold">(Requerido)</span>
                            @endif
                        </li>
                    @endforeach

                </ul>
            </div>
        @endforeach
    </div>
</body>

</html>
