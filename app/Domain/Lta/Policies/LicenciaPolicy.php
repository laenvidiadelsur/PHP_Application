<?php

namespace App\Domain\Lta\Policies;

use App\Models\User;
use App\Domain\Lta\Models\Licencia;

class LicenciaPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function view(User $user, Licencia $licencia): bool
    {
        return $user->can('access-admin');
    }

    public function create(User $user): bool
    {
        return $user->can('access-admin');
    }

    public function update(User $user, Licencia $licencia): bool
    {
        return $user->can('access-admin');
    }

    public function delete(User $user, Licencia $licencia): bool
    {
        return $user->can('access-admin');
    }
}

