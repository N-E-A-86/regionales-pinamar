<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Recuerdos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Mensaje de Éxito (Si la foto se subió bien) -->
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                    <span class="block sm:inline">{{ session('status') }}</span>
                </div>
            @endif

            <!-- Tarjeta del Formulario -->
            <div class="bg-white dark:bg-dark-card overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-bold mb-4">📸 ¡Sube tu foto con el Mate!</h3>
                    
                    <form action="{{ route('photos.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf <!-- Llave de seguridad obligatoria -->
                        
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Selecciona tu mejor foto
                            </label>
                            <input type="file" name="photo" required 
                                class="block w-full text-sm text-gray-500 dark:text-gray-400
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-sm file:font-semibold
                                file:bg-orange-50 file:text-orange-700
                                hover:file:bg-orange-100
                                dark:file:bg-gray-700 dark:file:text-gray-200
                                ">
                        </div>

                        <button type="submit" class="bg-brand-orange hover:bg-brand-orange-darker text-white font-bold py-2 px-4 rounded">
                            Subir Recuerdo
                        </button>
                    </form>
                </div>
            </div>

        <!-- SECCIÓN: MIS RECUERDOS -->
            <div class="mt-8">
                <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">📂 Mis Recuerdos Subidos</h3>

                @if($photos->isEmpty())
                    <p class="text-gray-500 dark:text-gray-400">Aún no has subido ninguna foto.</p>
                @else
                    <!-- Grid de Fotos -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach($photos as $photo)
                            <div class="bg-white dark:bg-dark-card rounded-lg shadow overflow-hidden relative group">
                                
                                <!-- La Imagen -->
                                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                     alt="Mi recuerdo" 
                                     class="w-full h-48 object-cover">

                                <!-- Badge de Estado (Flotante) -->
                                <div class="absolute top-2 right-2">
                                    @if($photo->status == 'approved')
                                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                                            Aprobada
                                        </span>
                                    @elseif($photo->status == 'rejected')
                                        <span class="bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                                            Rechazada
                                        </span>
                                    @else
                                        <span class="bg-yellow-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow">
                                            Pendiente
                                        </span>
                                    @endif
                                </div>

                                <!-- Info Pie de Foto -->
                                <div class="p-4">
                                    <div class="flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                        <span>❤️ {{ $photo->likes_count }} Likes</span>
                                        <span>💬 {{ $photo->comments_count }} Coment.</span>
                                    </div>
                                    <p class="text-xs text-gray-400 mt-2">Subida el {{ $photo->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>