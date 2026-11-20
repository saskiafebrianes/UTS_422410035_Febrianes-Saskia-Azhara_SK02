@props(['variant' => 'indigo'])

<span {{ $attributes->class([
    'inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full',
    'bg-indigo-900/70 text-indigo-300 border border-indigo-700' => $variant === 'indigo',
    'bg-amber-900/70 text-amber-300 border border-amber-700' => $variant === 'amber',
]) }}>
    {{ $slot }}
</span>
