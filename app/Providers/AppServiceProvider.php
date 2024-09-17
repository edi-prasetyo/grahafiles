<?php

namespace App\Providers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Option;
use App\Models\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;


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
        view()->composer('*', function ($view) {
            $view
                ->with('global_categories', Category::all())
                ->with('option', Option::first())
                ->with('pages', Page::all())
                ->with('top_banner', Banner::where('position', 'top')->get())
                ->with('sidebar_banner', Banner::where('position', 'sidebar')->get())
                ->with('list_banner', Banner::where('position', 'list')->get())
                ->with('download_banner', Banner::where('position', 'download')->get())
            ;
        });
        Paginator::useBootstrapFive();
    }
}
