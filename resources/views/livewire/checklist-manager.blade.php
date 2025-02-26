<div>
    <h2 class="text-lg font-bold">{{ $record->name }} - Checklists</h2>

    <div class="space-y-4 mt-4">
        @php
            $foundPending = false; // Variable para rastrear si hay tareas pendientes
        @endphp

        @foreach ($checklists as $checklist)
            @php
                $isPending = !$checklist['completed'];
                $isLocked = $foundPending; // Bloqueamos si ya encontramos un pendiente antes
                $isFinalized = $record->status === 1; // Proyecto finalizado
                if ($isPending) {
                    $foundPending = true; // Marcamos que hemos encontrado un pendiente
                }
            @endphp

            <div
                class="p-4 border rounded-md 
                {{ $checklist['completed'] ? 'bg-green-100 text-green-900' : 'bg-gray-100 dark:bg-gray-800 text-gray-900 dark:text-gray-100' }}
                {{ $isLocked ? 'opacity-50 pointer-events-none' : '' }}
                {{ $isFinalized ? 'opacity-50 pointer-events-none' : '' }}">
                <!-- Deshabilitamos si está bloqueado o si el proyecto está finalizado -->

                <h3 class="font-semibold">{{ $checklist['task'] }}</h3>

                <p>Estado:
                    <span class="{{ $checklist['completed'] ? 'text-green-600 font-bold' : 'text-red-600 font-bold' }}">
                        {{ $checklist['completed'] ? 'Completado' : 'Pendiente' }}
                    </span>
                </p>

                <h4 class="mt-2 font-semibold">Checks:</h4>

                <ul>
                    @foreach ($checklist['checks'] as $check)
                        <li class="flex items-center space-x-2">
                            <input type="checkbox"
                                wire:click="toggleCheck({{ $checklist['id'] }}, {{ $check['id'] }}, $event.target.checked)"
                                {{ $check['checked'] ? 'checked' : '' }} 
                                {{ $isLocked || $isFinalized ? 'disabled' : '' }}>
                            <!-- Bloquea si está bloqueado o si el proyecto está finalizado -->
                            <span>{{ $check['name'] }}</span>
                            @if ($check['required'])
                                <span class="text-red-500 font-bold">(Requerido)</span>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @if ($isLocked)
                    <p class="text-red-600 font-bold mt-2">Esta tarea está bloqueada porque la anterior aún está
                        pendiente.</p>
                @endif
                @if ($isFinalized)
                    <p class="text-red-600 font-bold mt-2">El proyecto está finalizado, no puedes modificar los checklists.</p>
                @endif

            </div>
        @endforeach
    </div>

    <div class="flex space-x-2 mt-3">
        <button wire:click="exportPDF({{ $record->id }})" class="bg-blue-500 text-black px-4 py-2 rounded-md">
            Descargar PDF
        </button>

        <!-- Botón para enviar correo -->
        <button wire:click="sendEmail({{ $record->id }})"
            class="px-4 py-2 bg-blue-600 text-black dark:text-white rounded hover:bg-blue-700">
            Enviar por Correo
        </button>

        @if ($record->status === 0 && $record->projectProjectChecklists->every(fn($checklist) => $checklist->completed))
            <button wire:click="finalizeProject()" class="bg-green-500 text-black px-4 py-2 rounded-md mt-4">
                Finalizar Proyecto</button>
        @endif
    </div>
</div>
