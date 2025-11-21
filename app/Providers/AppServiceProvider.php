<?php

namespace App\Providers;

use App\Models\CartItem;
use App\Models\Category;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        View::composer('frontend.partials.navbar', function ($view) {
            $view->with('navbarCategories', Category::all());
        });

        Paginator::useTailwind();

        View::composer('*', function ($view) {
        $cartCount = 0;

        if (Auth::check()) {
            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $sessionCart = Session::get('cart', []);
            foreach ($sessionCart as $item) {
                $cartCount += $item['quantity'];
            }
        }

        $view->with('globalCartCount', $cartCount);
    });
    }
}
