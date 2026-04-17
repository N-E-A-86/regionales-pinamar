<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ranking de Popularidad - Regionales Pinamar</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="antialiased font-sans bg-gray-100 dark:bg-dark-bg text-gray-900 dark:text-gray-200">
    
    <!-- Navbar simple -->
    <nav class="bg-white dark:bg-dark-card shadow p-4 mb-6">
    <div class="max-w-7xl mx-auto flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-brand-orange font-bold text-xl flex items-center hover:text-yellow-500 transition duration-150">
            
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            
            Volver a la Galería
        </a>
        <span class="text-xl font-bold">🏆 Top 5 Del Mundo</span>
    </div>
</nav>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        
        <div class="bg-white dark:bg-dark-card rounded-lg shadow-lg overflow-hidden">
    <div class="p-6 bg-gradient-to-r from-yellow-500 to-orange-500 text-black text-center">
        <h1 class="text-3xl font-extrabold">Salón de la Fama</h1>
        <p class="mt-2 opacity-90">Las fotos con más "Me Gusta" de la historia</p>
    </div>
</div>

            <div class="divide-y divide-gray-200 dark:divide-gray-700">
                @foreach($topPhotos as $index => $photo)
                    <div class="p-4 flex items-center hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                        
                        <!-- Posición (Medallas) -->
                        <div class="flex-shrink-0 w-12 text-center">
                            @if($index == 0)
                                <span class="text-4xl">🥇</span>
                            @elseif($index == 1)
                                <span class="text-4xl">🥈</span>
                            @elseif($index == 2)
                                <span class="text-4xl">🥉</span>
                            @else
                                <span class="text-xl font-bold text-gray-500">#{{ $index + 1 }}</span>
                            @endif
                        </div>

                        <!-- Foto Miniatura -->
                        <a href="{{ route('photos.show', $photo->id) }}" class="ml-4 flex-shrink-0 h-16 w-16 sm:h-20 sm:w-20 rounded-lg overflow-hidden border border-gray-300 dark:border-gray-600">
                            <img class="h-full w-full object-cover" src="{{ asset('storage/' . $photo->file_path) }}" alt="">
                        </a>

                        <!-- Info -->
                        <div class="ml-4 flex-1">
                            <div class="text-lg font-bold text-gray-900 dark:text-white">
                                {{ $photo->user->name }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                {{ $photo->created_at->format('d/m/Y') }}
                            </div>
                        </div>

                        <!-- Likes -->
                        <div class="text-right px-4">
                            <div class="text-2xl font-bold text-red-500 flex items-center">
                                <span class="mr-1">❤️</span> {{ $photo->likes_count }}
                            </div>
                            <div class="text-xs text-gray-500 uppercase tracking-wide">Votos</div>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    </div>

</body>
</html>