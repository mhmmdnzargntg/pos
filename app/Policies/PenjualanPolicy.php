<?php

namespace App\Policies;

use App\Models\Penjualan;
use App\Models\User;

class PenjualanPolicy
{
    /**
     * Mengatur izin untuk tombol EDIT
     */
    public function update(User $user, Penjualan $penjualan): bool
    {
        return $user->role->name === 'admin'
        && $penjualan->status === 'OPEN';
    }

    /**
     * Mengatur izin untuk tombol HAPUS
     */
    public function delete(User $user, Penjualan $penjualan): bool
    {
        return $user->role->name === 'admin'
        && $penjualan->status === 'OPEN';
    }
}