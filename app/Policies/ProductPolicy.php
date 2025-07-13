<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Determina se o utilizador pode visualizar qualquer produto.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determina se o utilizador pode visualizar um produto.
     */
    public function view(User $user, Product $product): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determina se o utilizador pode criar produtos.
     */
    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determina se o utilizador pode atualizar o produto.
     */
    public function update(User $user, Product $product): bool
    {
        return $user->hasRole('admin');
    }

    /**
     * Determina se o utilizador pode apagar o produto.
     */
    public function delete(User $user, Product $product): bool
    {
        return $user->hasRole('admin');
    }
}
