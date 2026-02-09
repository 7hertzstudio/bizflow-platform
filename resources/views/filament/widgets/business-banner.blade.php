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
                <div class="mt-4 flex gap-2">
                    <a href="{{ \App\Filament\Resources\TenantDomains\TenantDomainResource::getUrl('index', ['tenant' => $record->id]) }}" 
                       class="inline-flex items-center gap-1 rounded-lg bg-white/20 px-3 py-1.5 text-xs font-medium text-white hover:bg-white/30 transition backdrop-blur-md border border-white/30">
                        <x-heroicon-m-globe-alt class="h-4 w-4" />
                        Manage Domains
                    </a>
                    <a href="{{ \App\Filament\Resources\TenantDomains\TenantDomainResource::getUrl('create', ['tenant' => $record->id]) }}" 
                       class="inline-flex items-center gap-1 rounded-lg bg-white/20 px-3 py-1.5 text-xs font-medium text-white hover:bg-white/30 transition backdrop-blur-md border border-white/30">
                        <x-heroicon-m-plus class="h-4 w-4" />
                        Add Domain
                    </a>
                </div>
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
