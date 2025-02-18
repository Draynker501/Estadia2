<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist PDF</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; margin: auto; }
        .title { font-size: 20px; font-weight: bold; text-align: center; margin-bottom: 10px; }
        .section { padding: 10px; border-bottom: 1px solid #ccc; }
        .completed { color: green; font-weight: bold; }
        .pending { color: red; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="title">{{ $record->name }} - Checklists</div>

        @php
            $firstPendingFound = false; // Para saber cuál es el primer pendiente
        @endphp

        @foreach ($record->projectChecklistRels as $projectChecklistRel)
            @php
                $isPending = !$projectChecklistRel->completed;
                $isLocked = $firstPendingFound; // Bloqueamos si ya encontramos un pendiente antes
                if ($isPending) {
                    $firstPendingFound = true; // Marcar que hemos encontrado el primer pendiente
                }
            @endphp

            <div class="section">
                <h3>{{ $projectChecklistRel->projectChecklist->task }}</h3>
                <h4>Checks:</h4>
                <ul>
                    @foreach ($projectChecklistRel->projectChecklist->projectChecks as $projectCheck)
                        @php
                            $checked = optional(
                                $projectCheck->projectChecklistChecks
                                    ->where('project_checklist_rel_id', $projectChecklistRel->id)
                                    ->first(),
                            )->checked;
                        @endphp
                        <li>
                            <input type="checkbox" {{ $checked ? 'checked' : '' }} disabled>
                            {{ $projectCheck->name }} 
                            @if ($projectCheck->required)
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
