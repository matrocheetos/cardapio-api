<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        // Gate::define('viewApiDocs', function (User $user) {
        //     return in_array($user->email, ['admin@app.com']);
        // });
        Gate::define('viewApiDocs', function (?User $user = null) {
            return true;
        });
    }
}
