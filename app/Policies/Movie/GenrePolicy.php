<?php

namespace App\Policies\Movie;

use App\Models\User\Admin;
use App\Models\Movie\Genre;
use Illuminate\Auth\Access\HandlesAuthorization;

class GenrePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_movie::genre');
    }

    /**
     * Determine whether the admin can view the model.
     */
    public function view(Admin $admin, Genre $genre): bool
    {
        return $admin->can('view_movie::genre');
    }

    /**
     * Determine whether the admin can create models.
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_movie::genre');
    }

    /**
     * Determine whether the admin can update the model.
     */
    public function update(Admin $admin, Genre $genre): bool
    {
        return $admin->can('update_movie::genre');
    }

    /**
     * Determine whether the admin can delete the model.
     */
    public function delete(Admin $admin, Genre $genre): bool
    {
        return $admin->can('delete_movie::genre');
    }

    /**
     * Determine whether the admin can bulk delete.
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_movie::genre');
    }

    /**
     * Determine whether the admin can permanently delete.
     */
    public function forceDelete(Admin $admin, Genre $genre): bool
    {
        return $admin->can('force_delete_movie::genre');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('force_delete_any_movie::genre');
    }

    /**
     * Determine whether the admin can restore.
     */
    public function restore(Admin $admin, Genre $genre): bool
    {
        return $admin->can('restore_movie::genre');
    }

    /**
     * Determine whether the admin can bulk restore.
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('restore_any_movie::genre');
    }

    /**
     * Determine whether the admin can replicate.
     */
    public function replicate(Admin $admin, Genre $genre): bool
    {
        return $admin->can('replicate_movie::genre');
    }

    /**
     * Determine whether the admin can reorder.
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('reorder_movie::genre');
    }
}
