<?php

namespace App\Policies;
use App\Models\itemPenjualan;
use App\Models\User;

class ItemPenjualanPolicy
{

    public function delete(User $user, itemPenjualan $itemPenjualan): bool
    {
        return $user->role->name ==='admin';
    }
}
