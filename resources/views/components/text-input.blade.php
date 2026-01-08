@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-corp dark:border-corp-dark dark:bg-gray-900 dark:text-gray-300 focus:border-corp focus:ring-corp dark:focus:border-corp-dark dark:focus:ring-corp-dark rounded-md shadow-sm']) !!}>
