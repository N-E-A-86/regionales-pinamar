
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

                    <!-- Bloque para mostrar errores de validación -->
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    <strong class="font-bold">¡Ups! Algo salió mal:</strong>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                                hover:file:bg-blue-300
                                dark:file:bg-white-700 dark:file:text-black
                                ">
                        </div>

                        <button type="submit" class="bg-brand-orange hover:bg-brand-orange-darker text-black font-bold py-2 px-4 rounded">
                            Subir Recuerdo
                        </button>
                    </form>
                </div>
            </div>

               <!-- SECCIÓN: PROMOCIONES ACTIVAS -->
            @if($promotions->count() > 0)
                <div class="mb-10">
                    <h3 class="text-lg font-bold mb-4 text-gray-900 dark:text-gray-100">🎁 Tus Recompensas Disponibles</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($promotions as $promo)
                            <div class="bg-gradient-to-r from-orange-500 to-red-500 rounded-lg shadow-lg overflow-hidden text-white flex relative">
                                <!-- Imagen Promo -->
                                <div class="w-1/3 bg-black">
                                    <img src="{{ asset('storage/' . $promo->image_path) }}" class="h-full w-full object-cover opacity-80">
                                </div>
                                <!-- Texto -->
                                <div class="w-2/3 p-4 flex flex-col justify-center">
                                    <h4 class="font-bold text-xl">{{ $promo->title }}</h4>
                                    <p class="text-sm opacity-90 mt-1">{{ $promo->description }}</p>
                                    <p class="text-xs mt-3 font-mono bg-white bg-opacity-20 inline-block px-2 py-1 rounded">
                                        Muestra esto en caja
                                    </p>
                                </div>
                                <!-- Botón Borrar (Solo visible para Admin, por si la ve desde aquí) -->
                                @if(auth()->user()->role == 'admin')
                                    <form action="{{ route('promotions.destroy', $promo->id) }}" method="POST" class="absolute top-2 right-2">
                                        @csrf @method('DELETE')
                                        <button class="text-white hover:text-gray-200 bg-black bg-opacity-50 rounded-full p-1">❌</button>
                                    </form>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

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