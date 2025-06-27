<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Filament\Support\Facades\FilamentView;
use Illuminate\Support\Facades\Blade;


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
    // Add CSRF token to Filament head
    FilamentView::registerRenderHook(
        'panels::head.start',
        fn (): string => Blade::render('
            <meta name="csrf-token" content="{{ csrf_token() }}">
            <script>
                window.Laravel = {
                    csrfToken: "{{ csrf_token() }}"
                };
            </script>
        ')
    );
}
}