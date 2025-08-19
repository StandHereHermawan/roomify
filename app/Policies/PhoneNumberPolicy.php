<?php

namespace App\Policies;

use App\Domains\User\Model\SiprUser;
use App\Domains\User\Model\SiprPhoneNumber;

use Illuminate\Auth\Access\Response;

use Illuminate\Support\Facades\Log;

class PhoneNumberPolicy
{
    public const UPDATE = 'update';
    public const DELETE = 'delete';

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(SiprUser $siprUser): bool
    {
        return false;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(SiprUser $siprUser, SiprPhoneNumber $siprPhoneNumber): bool
    {
        return $siprPhoneNumber->ownedByUsers()->where(SiprUser::TABLE_NAME . '.' . SiprUser::ID, '=', $siprUser->getId())->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(SiprUser $siprUser): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(SiprUser $siprUser, SiprPhoneNumber $siprPhoneNumber): bool
    {
        return $siprPhoneNumber->ownedByUsers()->where(SiprUser::TABLE_NAME . '.' . SiprUser::ID, '=', $siprUser->getId())->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(SiprUser $siprUser, SiprPhoneNumber $siprPhoneNumber): bool
    {
        return $siprPhoneNumber->ownedByUsers()->where(SiprUser::TABLE_NAME . '.' . SiprUser::ID, '=', $siprUser->getId())->exists();
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(SiprUser $siprUser, SiprPhoneNumber $siprPhoneNumber): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(SiprUser $siprUser, SiprPhoneNumber $siprPhoneNumber): bool
    {
        Log::debug("class: EmailPolicy | method: forceDelete | called.");
        return false;
    }
}
