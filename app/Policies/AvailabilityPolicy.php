<?php

namespace App\Policies;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AvailabilityPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Availability $availability): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Availability $availability): bool
    {
        return $user->ownsAvailability($availability);
    }

    public function delete(User $user, Availability $availability): bool
    {
        return $user->ownsAvailability($availability);
    }

    public function deleteAny(User $user): bool
    {
        return false;
    }

    public function restore(User $user, Availability $availability): bool
    {
        return $user->ownsAvailability($availability);
    }

    public function forceDelete(User $user, Availability $availability): bool
    {
        return $user->ownsAvailability($availability);
    }
}
