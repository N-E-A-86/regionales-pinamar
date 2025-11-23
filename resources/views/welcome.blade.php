<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
            <p class="mt-3 max-w-md mx-auto text-base text-gray-500 dark:text-gray-400 sm:text-lg md:mt-5 md:text-xl md:max-w-3xl">
                ¡Sube tu foto, consigue likes y gana premios exclusivos!
            </p>
            <div class="mt-5 max-w-md mx-auto sm:flex sm:justify-center md:mt-8">
                <div class="rounded-md shadow">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-bold rounded-md text-black bg-brand-orange hover:bg-brand-orange-darker md:py-4 md:text-lg md:px-10">
                            📸 Subir mi Foto
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-brand-orange hover:bg-brand-orange-darker md:py-4 md:text-lg md:px-10">
                            🚀 Participar Ahora
                        </a>
                    @endauth
                </div>
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
                        <div class="bg-white dark:bg-dark-card rounded-lg shadow-lg overflow-hidden transition hover:scale-105 duration-300">
                            <!-- Imagen -->
                            <div class="h-64 overflow-hidden bg-gray-200 dark:bg-gray-800">
                                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                                     alt="Foto de {{ $photo->user->name }}" 
                                     class="w-full h-full object-cover">
                            </div>

                            <!-- Info y Botones -->
                            <div class="p-4">
                                <p class="text-sm font-bold text-gray-800 dark:text-gray-200 truncate">
                                    {{ $photo->user->name }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">
                                    {{ $photo->created_at->diffForHumans() }}
                                </p>

                                <div class="flex justify-between items-center border-t border-gray-100 dark:border-gray-700 pt-3">
                                    <!-- Botón de Like (Visual por ahora) -->
                                    <button class="flex items-center space-x-1 text-gray-500 hover:text-red-500 transition group">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 group-hover:fill-current" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                        </svg>
                                        <span class="font-bold">{{ $photo->likes_count }}</span>
                                    </button>

                                    <button class="text-gray-500 hover:text-blue-500">
                                        💬 {{ $photo->comments_count }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </body>
</html>