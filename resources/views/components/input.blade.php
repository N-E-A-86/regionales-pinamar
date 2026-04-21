@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'rounded-md shadow-sm border-2 border-gray-600 dark:border-gray-500 bg-gray-800 dark:bg-gray-700 text-white dark:text-gray-100 focus:border-brand-orange focus:ring focus:ring-brand-orange focus:ring-opacity-30 transition duration-200']) !!}>
