<div class="relative overflow-hidden rounded-xl bg-gradient-to-r from-primary-600 to-primary-500 p-6 shadow-lg text-white">
    <div class="flex items-center justify-between relative z-10">
        <div class="flex items-center gap-4">
            {{-- Business Logo or Placeholder --}}
            <div class="h-16 w-16 rounded-lg bg-white/20 flex items-center justify-center backdrop-blur-md border border-white/30">
                <x-heroicon-o-building-office class="h-10 w-10 text-white" />
            </div>

            <div>
                <h1 class="text-2xl font-bold tracking-tight">
                    {{ $record->name }}
                </h1>
                <p class="text-primary-100 opacity-90">
                    Managed by: {{ $record->owner->name }}
                </p>
            </div>
        </div>

        <div class="flex flex-col items-end gap-2">
            <span class="rounded-full bg-white/20 px-3 py-1 text-xs font-semibold uppercase tracking-wider backdrop-blur-md border border-white/30">
                {{ $record->brand->name ?? 'Standard' }}
            </span>
            <p class="text-xs text-primary-100 italic">Account since {{ $record->created_at->format('M Y') }}</p>
        </div>
    </div>

    {{-- Optional: Add a subtle background pattern or icon --}}
    <x-heroicon-s-building-office class="absolute -right-4 -bottom-4 h-32 w-32 text-white/10 rotate-12" />
</div>
