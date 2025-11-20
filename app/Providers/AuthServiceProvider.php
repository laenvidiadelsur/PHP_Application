<?php

namespace App\Providers;

use App\Domain\Lta\Models\Licencia;
use App\Domain\Lta\Policies\LicenciaPolicy;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Licencia::class => LicenciaPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin', function (User $user): bool {
            return (bool) ($user->is_admin ?? false);
        });
    }
}

