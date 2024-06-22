<?php

namespace App\Providers;

use App\Models\Invoice;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class InvoiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $quantityInvoice = Invoice::where('status', 1)->count();
            $customerInvoice = Invoice::where('status', 1)->with('customer')->get();
            $view->with('quantityInvoice', $quantityInvoice)->with('customerInvoice', $customerInvoice);
        });
    }
}
