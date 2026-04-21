<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-brand-orange border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-brand-orange-darker active:bg-orange-700 focus:outline-none focus:ring ring-orange-300 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
