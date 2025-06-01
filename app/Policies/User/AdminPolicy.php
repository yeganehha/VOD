<?php

namespace App\Policies\User;

use App\Models\User\Admin;

use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the admin can view any models.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function viewAny(Admin $admin): bool
    {
        return $admin->can('view_any_user::admin');
    }

    /**
     * Determine whether the admin can view the model.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function view(Admin $admin): bool
    {
        return $admin->can('view_user::admin');
    }

    /**
     * Determine whether the admin can create models.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function create(Admin $admin): bool
    {
        return $admin->can('create_user::admin');
    }

    /**
     * Determine whether the admin can update the model.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function update(Admin $admin): bool
    {
        return $admin->can('update_user::admin');
    }

    /**
     * Determine whether the admin can delete the model.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function delete(Admin $admin): bool
    {
        return $admin->can('delete_user::admin');
    }

    /**
     * Determine whether the admin can bulk delete.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function deleteAny(Admin $admin): bool
    {
        return $admin->can('delete_any_user::admin');
    }

    /**
     * Determine whether the admin can permanently delete.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function forceDelete(Admin $admin): bool
    {
        return $admin->can('force_delete_user::admin');
    }

    /**
     * Determine whether the admin can permanently bulk delete.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function forceDeleteAny(Admin $admin): bool
    {
        return $admin->can('force_delete_any_user::admin');
    }

    /**
     * Determine whether the admin can restore.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function restore(Admin $admin): bool
    {
        return $admin->can('restore_user::admin');
    }

    /**
     * Determine whether the admin can bulk restore.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function restoreAny(Admin $admin): bool
    {
        return $admin->can('restore_any_user::admin');
    }

    /**
     * Determine whether the admin can bulk restore.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function replicate(Admin $admin): bool
    {
        return $admin->can('replicate_user::admin');
    }

    /**
     * Determine whether the admin can reorder.
     *
     * @param  \App\Models\User\Admin  $admin
     * @return bool
     */
    public function reorder(Admin $admin): bool
    {
        return $admin->can('reorder_user::admin');
    }
}
