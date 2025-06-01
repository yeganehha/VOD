<?php

namespace App\Policies\Movie;

use App\Models\User\Admin;
use App\Models\Movie\CrewPosition;
use Illuminate\Auth\Access\HandlesAuthorization;

class CrewPositionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_movie::crew::position');
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, CrewPosition $crewPosition): bool
    {
        return $admin->can('view_movie::crew::position');
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_movie::crew::position');
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, CrewPosition $crewPosition): bool
    {
        return $admin->can('update_movie::crew::position');
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, CrewPosition $crewPosition): bool
    {
        return $admin->can('delete_movie::crew::position');
    }

    /**
     * Determine whether the admin can bulk delete.
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_movie::crew::position');
    }

    /**
     * Determine whether the admin can permanently delete.
     */
    public function forceDelete(Admin $admin, CrewPosition $crewPosition): bool
    {
        return $admin->can('force_delete_movie::crew::position');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('force_delete_any_movie::crew::position');
    }

    /**
     * Determine whether the admin can restore.
     */
    public function restore(Admin $admin, CrewPosition $crewPosition): bool
    {
        return $admin->can('restore_movie::crew::position');
    }

    /**
     * Determine whether the admin can bulk restore.
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('restore_any_movie::crew::position');
    }

    /**
     * Determine whether the admin can replicate.
     */
    public function replicate(Admin $admin, CrewPosition $crewPosition): bool
    {
        return $admin->can('replicate_movie::crew::position');
    }

    /**
     * Determine whether the admin can reorder.
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('reorder_movie::crew::position');
    }
}
