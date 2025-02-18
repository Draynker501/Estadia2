<x-filament::page>
    <h2 class="text-lg font-bold">{{ $record->name }} - Checklists</h2>

    <div class="space-y-4 mt-4">
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

            <div
                class="p-4 border rounded-md 
                {{ $isLocked ? 'bg-gray-300 dark:bg-gray-700 text-gray-500 dark:text-gray-400' : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' }}">

                <h3 class="font-semibold">{{ $projectChecklistRel->projectChecklist->task }}</h3>

                <p>Estado:
                    @if ($projectChecklistRel->completed)
                        <span class="text-green-600 dark:text-green-400 font-bold">Completado</span>
                    @else
                        <span class="text-red-600 dark:text-red-400 font-bold">Pendiente</span>
                    @endif
                </p>

                <h4 class="mt-2 font-semibold">Checks:</h4>

                <form method="POST" action="{{ route('project-checklist.updateChecks', $projectChecklistRel->id) }}">
                    @csrf
                    <input type="hidden" name="project_checklist_rel_id" value="{{ $projectChecklistRel->id }}">

                    <ul>
                        @foreach ($projectChecklistRel->projectChecklist->projectChecks as $projectCheck)
                            @php
                                $checked = optional(
                                    $projectCheck->projectChecklistChecks
                                        ->where('project_checklist_rel_id', $projectChecklistRel->id)
                                        ->first(),
                                )->checked;
                            @endphp
                            <li class="flex items-center space-x-2">
                                <input type="hidden" name="checks[{{ $projectCheck->id }}]" value="0">

                                <input type="checkbox" name="checks[{{ $projectCheck->id }}]" value="1"
                                    {{ $projectCheck->projectChecklistChecks->firstWhere('checked', 1) ? 'checked' : '' }}>

                                <span>{{ $projectCheck->name }}</span>
                                @if ($projectCheck->required)
                                    <span class="text-red-500 font-bold">(Requerido)</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>

                    <button type="submit"
                        class="mt-3 px-4 py-2 bg-blue-600 text-black dark:text-white rounded hover:bg-blue-700 {{ $isLocked ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $isLocked ? 'disabled' : '' }}>
                        Guardar cambios
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="flex space-x-2 mt-3">
        <!-- Botón para descargar PDF -->
        <a href="{{ route('project-checklist.pdf', $record->id) }}"
            class="px-4 py-2 bg-green-600 text-black dark:text-white rounded hover:bg-green-700">
            Descargar PDF
        </a>

        <!-- Botón para enviar correo -->
        <form method="POST" action="{{ route('project-checklist.email', $record->id) }}" class="flex items-center">
            @csrf
            <button type="submit" class="px-4 py-2 bg-blue-600 text-black dark:text-white rounded hover:bg-blue-700">
                Enviar por Correo
            </button>
        </form>
    </div>

</x-filament::page>
