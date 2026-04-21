<!-- Logo de Regionales Pinamar con Mate y Texto -->
<div class="flex flex-col items-center justify-center">
    <!-- Icono de Mate en SVG -->
    <svg viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg" {{ $attributes }} class="mb-2">
        <!-- Mate (Taza) -->
        <path d="M30 20 Q30 15 35 15 L65 15 Q70 15 70 20 L70 60 Q70 70 50 75 Q30 70 30 60 Z" fill="none" stroke="#FF8C00" stroke-width="2"/>
        <!-- Yerba dentro -->
        <ellipse cx="50" cy="50" rx="15" ry="8" fill="#FF8C00" opacity="0.3"/>
        <!-- Bombilla -->
        <rect x="48" y="25" width="4" height="35" fill="#FF8C00"/>
        <circle cx="50" cy="30" r="3" fill="#FF8C00"/>
        <!-- Steam (Humo) -->
        <path d="M 40 10 Q 38 5 42 2" stroke="#FF8C00" stroke-width="1.5" fill="none" stroke-linecap="round" opacity="0.7"/>
        <path d="M 50 8 Q 48 2 52 0" stroke="#FF8C00" stroke-width="1.5" fill="none" stroke-linecap="round" opacity="0.7"/>
        <path d="M 60 10 Q 58 4 62 1" stroke="#FF8C00" stroke-width="1.5" fill="none" stroke-linecap="round" opacity="0.7"/>
    </svg>
    <!-- Texto -->
    <div class="text-center">
        <p class="text-lg font-bold text-brand-orange">🧉 Regionales</p>
        <p class="text-sm text-brand-orange font-semibold">Pinamar</p>
    </div>
</div>
