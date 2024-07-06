<?php

namespace App\Policies;

use App\Models\NonPlayerCharacter;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class NonPlayerCharacterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NonPlayerCharacter $nonPlayerCharacter): Response
    {
        return $nonPlayerCharacter->public || $user->id === $nonPlayerCharacter->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NonPlayerCharacter $nonPlayerCharacter): Response
    {
        return $user->id === $nonPlayerCharacter->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NonPlayerCharacter $nonPlayerCharacter): Response
    {
        return $user->id === $nonPlayerCharacter->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NonPlayerCharacter $nonPlayerCharacter): Response
    {
        return $user->id === $nonPlayerCharacter->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NonPlayerCharacter $nonPlayerCharacter): Response
    {
        return $user->id === $nonPlayerCharacter->user_id
            ? Response::allow()
            : Response::denyAsNotFound();
    }
}
