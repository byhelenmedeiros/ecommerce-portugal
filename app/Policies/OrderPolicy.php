<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    /**
     * Determine whether the user can view any models.
     */
   public function viewAny(User $user)
{
    return $user->hasRole('admin');
}

    /**
     * Determine whether the user can view the model.
     */
public function view(User $user, Order $order): bool
{
    return $user->hasRole('admin') || $order->user_id === $user->id;
}

public function update(User $user, Order $order): bool
{
    return $order->user_id === $user->id && $order->status === 'pending';
}


    

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Order $order): bool
    {
        return $user->hasRole('admin') || $order->user_id === $user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Order $order): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Order $order): bool
    {
        return $user->hasRole('admin');
    }
}
