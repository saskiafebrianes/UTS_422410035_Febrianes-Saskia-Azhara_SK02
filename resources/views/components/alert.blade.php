@props(['type' => 'info'])

<div {{ $attributes->class([
    'p-4 mb-6 rounded-lg border text-sm font-medium',
    'bg-emerald-950/60 border-emerald-700 text-emerald-300' => $type === 'success',
    'bg-rose-950/60 border-rose-700 text-rose-300' => $type === 'danger',
    'bg-sky-950/60 border-sky-700 text-sky-300' => $type === 'info',
]) }}>
    {{ $slot }}
</div>
