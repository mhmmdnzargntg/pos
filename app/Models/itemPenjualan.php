<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class itemPenjualan extends Model
{     
      use HasFactory;
      
      protected $table = 'item_penjualan';

      protected $fillable = [
        'penjualan_id',
        'produk_id',
        'kuantitas',
        'harga_satuan',
        'subtotal',
    ];

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
    
       public function penjualan()
    {
       return $this->belongsTo(Penjualan::class, 'penjualan_id');
    }
}

