<nav class="bg-slate-950 border-b border-slate-800 px-6 py-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="{{ route('sesi.index') }}" class="text-xl font-bold text-indigo-400">
            🔭 DarkSky Observatory (SK02)
        </a>
        <div class="space-x-4">
            <a href="{{ route('sesi.index') }}" @class([
                'text-sm font-medium',
                'text-indigo-400 underline' => request()->routeIs('sesi.*'),
                'text-slate-300 hover:text-white' => !request()->routeIs('sesi.*'),
            ])>
                Sesi Pengamatan
            </a>
        </div>
    </div>
</nav>
