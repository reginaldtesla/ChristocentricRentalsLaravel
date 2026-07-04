<?php

namespace App\Providers;

use App\Support\AdminAccount;
use App\Support\SiteConfig;
use Illuminate\Support\Facades\View;
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
        SiteConfig::boot();
        AdminAccount::ensureExists();

        View::share('siteCategories', SiteConfig::categoriesForNav());
        View::share('currencySymbol', config('site.currency_symbol'));
        View::share('trendingSearches', config('site.trending_searches'));

        View::composer('*', function ($view) {
            $compare = app(\App\Services\CompareService::class);
            $view->with([
                'compareSlugs' => $compare->slugs(),
                'compareCount' => $compare->count(),
                'compareMax' => $compare->maxItems(),
            ]);
        });

        View::composer(['components.header', 'components.mobile-nav'], function ($view) {
            $view->with('cartCount', app(\App\Services\CartService::class)->count());
        });
    }
}
