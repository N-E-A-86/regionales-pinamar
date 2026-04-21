<div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-dark-bg">
    <div class="mb-8 transform hover:scale-105 transition duration-300">
        {{ $logo }}
    </div>

    <div class="w-full sm:max-w-md px-8 py-8 bg-dark-card shadow-2xl overflow-hidden sm:rounded-lg border-t-4 border-brand-orange">
        {{ $slot }}
    </div>
</div>
