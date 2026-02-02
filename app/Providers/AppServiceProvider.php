<?php

namespace App\Providers;

use App\Models\TenantInvoiceItem;
use App\Models\TenantQuoteItem;
use App\Observers\FinanceItemObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        TenantQuoteItem::observe(FinanceItemObserver::class);
        TenantInvoiceItem::observe(FinanceItemObserver::class);
    }
}