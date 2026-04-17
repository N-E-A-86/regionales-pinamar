<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Regionales Pinamar - Galería del Mate</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Estilos y Scripts (Mix) -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="antialiased font-sans bg-gray-100 dark:bg-dark-bg text-gray-900 dark:text-gray-200">
        
        <!-- Barra de Navegación Pública -->
        <div class="relative flex items-center justify-between px-6 py-4 bg-white dark:bg-dark-card shadow-md sm:px-10">
            <!-- Logo / Título -->
            <div class="flex items-center">
                <span class="text-2xl font-bold text-brand-orange">🧉 Regionales Pinamar</span>
            </div>

            <!-- Botones de Acción -->
            <div>
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-gray-700 dark:text-gray-300 underline hover:text-brand-orange">
                                Mi Panel
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 dark:text-gray-300 underline hover:text-brand-orange">
                                Iniciar Sesión
                            </a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="ml-4 text-sm font-bold text-gray-700 dark:text-gray-300 underline hover:text-brand-orange">
                                    Registrarse
                                </a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </div>

        <!-- Encabezado Principal (Hero) -->
        <div class="py-12 text-center bg-orange-50 dark:bg-gray-900">
            <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                <span class="block">El Mate Más Grande</span>
                <span class="block text-brand-orange">De Pinamar</span>
            </h1>
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-yellow-100 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                ¡Sube tu foto, consigue likes y gana premios exclusivos!
            </p>
            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                <div class="rounded-md shadow">
                    @auth
                        <!-- <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-black bg-brand-orange hover:bg-brand-orange-darker md:py-4 md:text-lg md:px-10">
                            📸 Subir mi Foto
                        </a> -->
                        <a href="{{ route('dashboard') }}" class="w-full 
    flex items-center justify-center 
    px-8 py-2
    border border-transparent 
    text-2xl font-bold 
    rounded-md 
    text-black 
    bg-brand-orange hover:bg-brand-orange-darker 
    md:py-4 md:text-3xl md:px-10">
    
    📸 Subir mi Foto
</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-brand-orange hover:bg-brand-orange-darker md:py-4 md:text-lg md:px-10">
                            🚀 Participar Ahora
                        </a>
                    @endauth
                    
                </div>
            </div>
            <!-- Enlace al Ranking -->
            <div class="mt-6">
    <a href="{{ route('ranking') }}" class="text-brand-orange hover:text-white font-bold text-lg border-b-2 border-brand-orange hover:bg-brand-orange px-2 py-1 transition">
        🏆 Ver Ranking de Ganadores
    </a>
</div>
        </div>

        <!-- Galería de Fotos -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-8 text-center">Últimos Recuerdos</h2>

            @if($photos->isEmpty())
                <div class="text-center py-20">
                    <p class="text-xl text-gray-500 dark:text-gray-400">Aún no hay fotos públicas. ¡Sé el primero!</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                   @foreach($photos as $photo)
                <div class="bg-white dark:bg-dark-card rounded-lg shadow-lg overflow-hidden transition hover:scale-105 duration-300 group">
                    
                    <!-- EL ENLACE PRINCIPAL (Envuelve imagen y datos) -->
                    <!-- Al hacer clic aquí, te lleva a la vista detalle -->
                    <a href="{{ route('photos.show', $photo->id) }}" class="block">
                        
                        <!-- Imagen --><div class="h-64 overflow-hidden bg-gray-200 dark:bg-gray-800 relative">
    
    <img src="{{ asset('storage/' . $photo->file_path) }}" 
        alt="Foto de {{ $photo->user->name }}" 
        class="w-full h-full object-cover transition duration-500 group-hover:opacity-90">
    
    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition duration-300 flex items-center justify-center">
        <span class="text-white opacity-0 group-hover:opacity-100 font-bold text-lg drop-shadow-md">Ver Foto 🔍</span>
    </div>
    
    @if(auth()->check() && auth()->user()->role == 'admin')
        <div class="absolute top-2 right-2 z-20">
            <form action="{{ route('photos.destroy', $photo->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 text-white p-2 rounded-full hover:bg-red-700 shadow-lg transition transform hover:scale-110"
                        onclick="return confirm('⚠️ ¿ADMIN: Estás seguro de borrar esta foto pública?');">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </form>
        </div>
    @endif
    </div>

                        <!-- Info del Usuario (Parte del enlace) -->
                        <div class="p-4 pb-2">
                            <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate group-hover:text-brand-orange transition">
                                {{ $photo->user->name }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                        @if($photo->created_at->isToday())
                            {{ $photo->created_at->diffForHumans() }}
                        @elseif($photo->created_at->isYesterday())
                            Ayer
                        @else
                            {{ $photo->created_at->format('d/m/Y') }}
                        @endif
                    </p>
                        </div>
                    </a> 
                    <!-- Fin del enlace -->

                    <!-- Botones de Acción (SEPARADOS del enlace para que funcionen independientemente) -->
                    <div class="px-4 pb-4 pt-2 flex justify-between items-center border-t border-gray-100 dark:border-gray-700">
                        
                       <!-- Botón de Like Inteligente -->
@php
    $isLiked = $photo->isLikedByAuthUser();
@endphp

<button onclick="toggleLike({{ $photo->id }}, this)" 
        class="flex items-center space-x-1 transition group transform duration-200 {{ $isLiked ? 'text-red-500' : 'text-gray-500 hover:text-red-500' }}">
    
    <svg xmlns="http://www.w3.org/2000/svg" 
         class="h-6 w-6 {{ $isLiked ? 'fill-current' : 'group-hover:fill-current' }}" 
         fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
    </svg>
    
   <span class="font-bold like-count text-white">{{ $photo->likes_count }}</span>
</button>

                        <!-- Indicador de Comentarios (Ahora es un enlace) -->
                        <!-- <a href="{{ route('photos.show', $photo->id) }}" 
                         class="flex items-center text-gray-500 hover:text-blue-500 transition text-sm font-medium z-10 relative">
                            <span class="mr-1">💬</span>
                            {{ $photo->comments_count }}
                        </a> -->
                        <a href="{{ route('photos.show', $photo->id) }}" 
                      class="flex items-center text-white hover:text-yellow-300 transform transition duration-300 text-base font-medium z-10 relative hover:scale-105">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
      <path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H2a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2zM7 7H5v2h2V7zm2 0h2v2H9V7zm4 0h2v2h-2V7z" clip-rule="evenodd" />
    </svg>
    Comentarios
    {{ $photo->comments_count }}
</a>
                    </div>

                </div>
            @endforeach
                </div>
            @endif
        </div>
<script>
    async function toggleLike(photoId, btn) {
        // 1. Verificamos si el usuario está logueado (si no hay token csrf, es que no está logueado)
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (!token) {
            window.location.href = "{{ route('login') }}"; // Lo mandamos a loguear
            return;
        }

        // 2. Referencias a los elementos visuales
        const icon = btn.querySelector('svg');
        const countSpan = btn.querySelector('.like-count');
        
        // Efecto visual inmediato (feedback táctil)
        btn.classList.add('scale-125'); 
        setTimeout(() => btn.classList.remove('scale-125'), 200);

        try {
            // 3. Enviamos la petición al servidor
            const response = await fetch(`/photos/${photoId}/like`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                }
            });

            const data = await response.json();

            // 4. Actualizamos el número y el color según lo que dijo el servidor
            countSpan.innerText = data.likes_count;

            if (data.liked) {
                // Si dio like: Ponemos rojo y rellenamos el corazón
                btn.classList.remove('text-gray-500');
                btn.classList.add('text-red-500');
                icon.classList.add('fill-current');
            } else {
                // Si quitó like: Ponemos gris y vaciamos el corazón
                btn.classList.add('text-gray-500');
                btn.classList.remove('text-red-500');
                icon.classList.remove('fill-current');
            }

        } catch (error) {
            console.error('Error al dar like:', error);
            alert('Hubo un error al procesar tu like.');
        }
    }
</script>
    </body>
</html>