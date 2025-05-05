<?php

namespace App\Providers;

use App\Events\Noticount;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
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
        View::composer('*', function ($view) {
            $user = Auth::user();
            $unread = 0;

            if ($user) {
                $unread = $user->unreadNotifications->count();
                event(new Noticount($user->id, $user->unreadNotifications->count()));

            }

            $view->with('Noticount', $unread);
        });
    }
}
