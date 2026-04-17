<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            🛡️ Panel de Moderación
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">


        <!-- SECCIÓN: CREAR PROMOCIÓN (Solo Admin) -->
            <div class="bg-white dark:bg-dark-card overflow-hidden shadow-sm sm:rounded-lg mb-8 border border-orange-200 dark:border-orange-900">
                <div class="p-6">
                    <h3 class="text-lg font-bold mb-4 text-brand-orange">🎁 Crear Nueva Promoción</h3>
                    <form action="{{ route('promotions.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4 md:flex-row">
                        @csrf
                        <div class="flex-1">
                            <input type="text" name="title" placeholder="Título (ej: 10% OFF)" required class="w-full rounded bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700 mb-2">
                            <input type="text" name="description" placeholder="Descripción corta..." required class="w-full rounded bg-gray-50 dark:bg-gray-800 border-gray-300 dark:border-gray-700">
                        </div>
                        <div class="flex-1">
                            <input type="file" name="image" required class="text-sm text-gray-500">
                        </div>
                        <button type="submit" class="bg-brand-orange hover:bg-brand-orange-darker text-white font-bold py-2 px-6 rounded h-10 self-center">
                            Publicar
                        </button>
                    </form>
                </div>
            </div>
            
            <!-- Mensajes de Feedback (Aprobado/Rechazado) -->
            @if (session('status'))
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <div class="bg-white dark:bg-dark-card overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    <h3 class="text-lg font-bold mb-6">Fotos Pendientes de Aprobación</h3>

                    @if($pendingPhotos->isEmpty())
                        <div class="text-center py-10">
                            <p class="text-gray-500 dark:text-gray-400 text-xl">🎉 ¡Todo limpio! No hay fotos pendientes.</p>
                        </div>
                    @else
                        <!-- Grid de Moderación -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($pendingPhotos as $photo)
                                <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden shadow-lg bg-gray-50 dark:bg-gray-800">
                                    
                                    <!-- Foto -->
                                    <div class="h-64 w-full bg-gray-200 dark:bg-gray-900 flex items-center justify-center overflow-hidden">
                                        <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                             alt="Foto pendiente" 
                                             class="object-contain h-full w-full">
                                    </div>

                                    <!-- Info del Usuario -->
                                    <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                        <p class="font-bold text-sm">👤 {{ $photo->user->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $photo->email }}</p>
                                        <p class="text-xs text-gray-400 mt-1">📅 {{ $photo->created_at->format('d/m/Y H:i') }}</p>
                                    </div>

                                    <!-- Botones de Acción -->
                                    <div class="p-4 flex gap-2">
                                        <!-- Botón APROBAR -->
                                        <form action="{{ route('admin.approve', $photo->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-sm transition">
                                                ✅ Aprobar
                                            </button>
                                        </form>

                                        <!-- Botón RECHAZAR -->
                                        <form action="{{ route('admin.reject', $photo->id) }}" method="POST" class="flex-1">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded text-sm transition" onclick="return confirm('¿Seguro que quieres borrar esta foto?')">
                                                ❌ Rechazar
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>