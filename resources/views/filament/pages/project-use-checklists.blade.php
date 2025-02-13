<x-filament::page>
    <h2 class="text-lg font-bold">{{ $record->name }} - Checklists</h2>

    <div class="space-y-4 mt-4">
        @php
            $firstPendingFound = false; // Para saber cuál es el primer pendiente
        @endphp

        @foreach ($record->projectChecklists as $projectChecklist)
            @php
                $isPending = !$projectChecklist->completed;
                $isLocked = $firstPendingFound; // Bloqueamos si ya encontramos un pendiente antes
                if ($isPending) {
                    $firstPendingFound = true; // Marcar que hemos encontrado el primer pendiente
                }
            @endphp

            <div class="p-4 border rounded-md 
                {{ $isLocked ? 'bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400' : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' }}">

                <h3 class="font-semibold">{{ $projectChecklist->checklist->task }}</h3>

                <p>Estado: 
                    @if ($projectChecklist->completed)
                        <span class="text-green-600 dark:text-green-400 font-bold">Completado</span>
                    @else
                        <span class="text-red-600 dark:text-red-400 font-bold">Pendiente</span>
                    @endif
                </p>

                <h4 class="mt-2 font-semibold">Checks:</h4>
                
                <form method="POST" action="{{ route('project-checklist.updateChecks', $projectChecklist->id) }}">
                    @csrf
                    <input type="hidden" name="project_checklist_id" value="{{ $projectChecklist->id }}">

                    <ul>
                        @foreach ($projectChecklist->checklist->checks as $check)
                            @php
                                $checked = optional($check->checkStatuses->where('project_checklist_id', $projectChecklist->id)->first())->checked;
                            @endphp
                            <li class="flex items-center space-x-2">
                                <input type="hidden" name="checks[{{ $check->id }}]" value="0">

                                <input type="checkbox" 
                                    name="checks[{{ $check->id }}]" 
                                    value="1"
                                    {{ $checked ? 'checked' : '' }}
                                    {{ $isLocked ? 'disabled' : '' }}>

                                <span>{{ $check->name }}</span>
                                @if ($check->required)
                                    <span class="text-red-500 font-bold">(Requerido)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-black dark:text-white rounded hover:bg-blue-700 {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}" {{ $isLocked ? 'disabled' : '' }}>
                        Guardar cambios
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</x-filament::page>
