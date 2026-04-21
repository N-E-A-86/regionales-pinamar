@props(['status'])

@if ($status)
    <div {{ $attributes->merge(['class' => 'font-medium text-sm text-green-400 dark:text-green-300 bg-green-900 dark:bg-green-800 bg-opacity-20 p-3 rounded-md border border-green-700 dark:border-green-600']) }}>
        {{ $status }}
    </div>
@endif
