<x-filament::page>
    <h2 class="text-lg font-bold">{{ $record->name }} - Checklists</h2>

    <div class="space-y-4 mt-4">
        @foreach ($record->projectChecklists as $projectChecklist)
            <div class="p-4 border rounded-md bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100">
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
                                {{-- Input hidden para asegurarnos de que los desmarcados se envían como 0 --}}
                                <input type="hidden" name="checks[{{ $check->id }}]" value="0">

                                <input type="checkbox" 
                                    name="checks[{{ $check->id }}]" 
                                    value="1"
                                    {{ $checked ? 'checked' : '' }}>

                                <span>{{ $check->name }}</span>
                                @if ($check->required)
                                    <span class="text-red-500 font-bold">(Requerido)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <button type="submit" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Guardar cambios
                    </button>
                </form>
            </div>
        @endforeach
    </div>
</x-filament::page>
