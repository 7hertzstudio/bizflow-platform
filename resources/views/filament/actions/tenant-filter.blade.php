<div x-data="{
    tenant: '{{ request()->query('tenant', 'all') }}',
    updateFilter() {
        const url = new URL(window.location.href);
        if (this.tenant && this.tenant !== 'all') {
            url.searchParams.set('tenant', this.tenant);
        } else if (this.tenant === 'all') {
            url.searchParams.set('tenant', 'all');
        } else {
            url.searchParams.delete('tenant');
        }
        // Remove page parameter when changing filter to avoid empty pages
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }
}" class="flex items-center">
    <select
        x-model="tenant"
        @change="updateFilter"
        class="fi-input block w-full border-none bg-white py-1.5 text-base text-gray-950 shadow-sm ring-1 ring-gray-950/10 focus:ring-2 focus:ring-primary-600 sm:text-sm sm:leading-6 dark:bg-white/5 dark:text-white dark:ring-white/20 dark:focus:ring-primary-500 rounded-lg min-w-[200px]"
    >
        <option value="all">All Tenants</option>
        @foreach(\App\Models\TenantBusiness::orderBy('name')->pluck('name', 'id') as $id => $name)
            <option value="{{ $id }}">{{ $name }}</option>
        @endforeach
    </select>
</div>