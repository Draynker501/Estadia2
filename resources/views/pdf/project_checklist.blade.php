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
        @foreach ($record->projectChecklists as $projectChecklist)
            <div class="section">
                <h3>{{ $projectChecklist->checklist->task }}</h3>
                <h4>Checks:</h4>
                <ul>
                    @foreach ($projectChecklist->checklist->checks as $check)
                        @php
                            $checked = optional($check->checkStatuses->where('project_checklist_id', $projectChecklist->id)->first())->checked;
                        @endphp
                        <li>
                            <input type="checkbox" {{ $checked ? 'checked' : '' }} disabled>
                            {{ $check->name }} 
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
</body>
</html>
