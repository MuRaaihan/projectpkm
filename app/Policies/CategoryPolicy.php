<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Guru BK dapat mengelola daftar kategori.
     */
    public function viewAny(User $user): bool
    {
        return $user->isBk();
    }

    /**
     * Hanya Guru BK yang dapat menambah kategori baru.
     */
    public function create(User $user): bool
    {
        return $user->isBk();
    }

    /**
     * Hanya Guru BK yang dapat mengubah kategori.
     */
    public function update(User $user, Category $category): bool
    {
        return $user->isBk();
    }

    /**
     * Hanya Guru BK yang dapat menghapus / menonaktifkan kategori.
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->isBk();
    }
}
