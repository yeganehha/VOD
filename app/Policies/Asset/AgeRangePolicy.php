<?php

namespace App\Policies\Asset;

use App\Models\User\Admin;
use App\Models\Asset\AgeRange;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgeRangePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_asset::age::range');
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, AgeRange $ageRange): bool
    {
        return $admin->can('view_asset::age::range');
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_asset::age::range');
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, AgeRange $ageRange): bool
    {
        return $admin->can('update_asset::age::range');
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, AgeRange $ageRange): bool
    {
        return $admin->can('delete_asset::age::range');
    }

    /**
     * Determine whether the admin can bulk delete.
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_asset::age::range');
    }

    /**
     * Determine whether the admin can permanently delete.
     */
    public function forceDelete(Admin $admin, AgeRange $ageRange): bool
    {
        return $admin->can('{{ ForceDelete }}');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('{{ ForceDeleteAny }}');
    }

    /**
     * Determine whether the admin can restore.
     */
    public function restore(Admin $admin, AgeRange $ageRange): bool
    {
        return $admin->can('restore_asset::age::range');
    }

    /**
     * Determine whether the admin can bulk restore.
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('restore_any_asset::age::range');
    }

    /**
     * Determine whether the admin can replicate.
     */
    public function replicate(Admin $admin, AgeRange $ageRange): bool
    {
        return $admin->can('replicate_asset::age::range');
    }

    /**
     * Determine whether the admin can reorder.
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('reorder_asset::age::range');
    }
}
