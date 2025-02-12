<x-filament::page>
    <h2 class="text-lg font-bold">{{ $record->name }} - Checklists</h2>

    <div class="space-y-4 mt-4">
        @foreach ($record->projectChecklists as $checklist)
            <div class="p-4 border rounded-md bg-gray-100 text-gray-900"> <!-- Cambié el color de fondo y el texto -->
                <h3 class="font-semibold">{{ $checklist->checklist->task }}</h3>
                <p>Estado: 
                    @if ($checklist->completed)
                        <span class="text-green-600 font-bold">Completado</span>
                    @else
                        <span class="text-red-600 font-bold">Pendiente</span>
                    @endif
                </p>

                @if (!$checklist->completed)
                    <form method="POST" action="{{ route('filament.resources.project-resource.review.mark-checklist', ['record' => $record->id]) }}">
                        @csrf
                        <input type="hidden" name="checklist_id" value="{{ $checklist->id }}">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">Marcar como Completado</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</x-filament::page>
