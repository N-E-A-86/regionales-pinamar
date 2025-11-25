<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Scripts y Estilos (CORREGIDO PARA MIX) -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>
    </head>
    <body class="font-sans antialiased dark:bg-dark-bg dark:text-gray-200">
        <div class="min-h-screen bg-gray-100 dark:bg-dark-bg">
            @include('layouts.navigation')

            <!-- Page Heading -->
            <header class="bg-white dark:bg-dark-card shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
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