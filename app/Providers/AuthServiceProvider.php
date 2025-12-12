<?php

namespace App\Providers;

use App\Domain\Lta\Models\Usuario;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('access-admin', function (Usuario $user): bool {
            return $user->isAdmin();
        });

        Gate::define('access-fundacion', function (Usuario $user): bool {
            return $user->isFundacion() && $user->isApproved() && $user->activo;
        });

        Gate::define('access-proveedor', function (Usuario $user): bool {
            return $user->isProveedor() && $user->isApproved() && $user->activo;
        });
    }
}

