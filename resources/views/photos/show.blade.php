<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recuerdo de {{ $photo->user->name }} - Regionales Pinamar</title>
    
    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="bg-black text-gray-200 font-sans antialiased">

    <!-- Barra de Navegación Minimalista (Estilo App) -->
    <nav class="border-b border-gray-800 bg-dark-card sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <!-- Botón Volver (Flecha Naranja) -->
                    <a href="{{ url('/') }}" class="flex items-center text-gray-400 hover:text-brand-orange transition">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                        <span class="font-bold hidden sm:inline">Volver a la Galería</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <span class="text-brand-orange font-bold text-lg">Regionales Pinamar</span>
                </div>
                <div class="flex items-center">
                     @auth
                        <a href="{{ route('dashboard') }}" class="text-sm font-medium text-gray-300 hover:text-white">Mi Panel</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-brand-orange hover:text-white transition border border-brand-orange hover:bg-brand-orange px-4 py-1 rounded-full">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenedor Principal (Layout 2 Columnas estilo Reddit Desktop) -->
    <main class="py-8 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- COLUMNA IZQUIERDA: La Foto (Ocupa 2/3 del espacio) -->
            <div class="lg:col-span-2">
                <div class="bg-dark-card border border-gray-800 rounded-lg overflow-hidden shadow-2xl">
                    <!-- Encabezado del Post -->
                    <div class="p-4 flex items-center border-b border-gray-800">
                        <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-brand-orange to-yellow-500 flex items-center justify-center text-white font-bold">
                            {{ substr($photo->user->name, 0, 1) }}
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-bold text-white">{{ $photo->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $photo->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- LA IMAGEN GRANDE -->
                    <div class="bg-black flex justify-center items-center min-h-[400px]">
                        <img src="{{ asset('storage/' . $photo->file_path) }}" 
                             alt="Foto de {{ $photo->user->name }}" 
                             class="max-h-screen max-w-full object-contain">
                    </div>

                    <!-- Barra de Acciones (Like/Comentar) -->
                    <div class="p-4 bg-dark-card border-t border-gray-800 flex items-center space-x-6">
                        
                        <!-- Botón LIKE (Estilo Reddit) -->
                        <button class="flex items-center space-x-2 text-gray-400 hover:text-brand-orange transition group">
                            <div class="p-2 rounded-full group-hover:bg-gray-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <span class="font-bold text-lg">{{ $photo->likes_count }} <span class="hidden sm:inline">Me Gusta</span></span>
                        </button>

                        <!-- Botón COMENTAR -->
                        <button class="flex items-center space-x-2 text-gray-400 hover:text-blue-400 transition group">
                            <div class="p-2 rounded-full group-hover:bg-gray-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 4.418 9 8z" />
                                </svg>
                            </div>
                            <span class="font-bold text-lg">{{ $photo->comments_count }} <span class="hidden sm:inline">Comentarios</span></span>
                        </button>

                        <!-- Botón COMPARTIR (Extra) -->
                        <button class="flex items-center space-x-2 text-gray-400 hover:text-green-400 transition group ml-auto">
                            <div class="p-2 rounded-full group-hover:bg-gray-800 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                                </svg>
                            </div>
                            <span class="font-bold text-sm hidden sm:inline">Compartir</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- COLUMNA DERECHA: Sidebar de Comentarios (Estilo StackOverflow/Facebook) -->
            <div class="lg:col-span-1">
                <div class="bg-dark-card border border-gray-800 rounded-lg p-6 shadow-lg sticky top-24">
                    <h3 class="text-xl font-bold text-white mb-4 border-b border-gray-700 pb-2">Comentarios</h3>
                    
                    <!-- Lista de Comentarios (Placeholder por ahora) -->
                    <div class="space-y-4 mb-6 max-h-96 overflow-y-auto custom-scrollbar">
                        <p class="text-gray-500 text-center py-4 italic">
                            Aún no hay comentarios. ¡Sé el primero en opinar sobre este mate!
                        </p>
                    </div>

                    <!-- Formulario de Comentario -->
                    @auth
                        <form action="#" class="mt-4">
                            <textarea rows="3" class="w-full bg-gray-900 border border-gray-700 rounded p-2 text-white focus:ring-2 focus:ring-brand-orange focus:border-transparent" placeholder="Escribe un comentario..."></textarea>
                            <button type="button" class="mt-2 w-full bg-brand-orange hover:bg-brand-orange-darker text-black font-bold py-2 px-4 rounded transition shadow-lg shadow-orange-500/20">
                                Publicar Comentario
                            </button>
                        </form>
                    @else
                        <div class="bg-gray-900 rounded p-4 text-center border border-gray-800">
                            <p class="text-gray-400 text-sm mb-3">Inicia sesión para dejar un comentario y darle like.</p>
                            <a href="{{ route('login') }}" class="block w-full bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded border border-gray-600 transition">
                                Iniciar Sesión
                            </a>
                        </div>
                    @endauth
                </div>
            </div>

        </div>
    </main>

</body>
</html>