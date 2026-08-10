<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemPenjualan;
use App\Models\itemPenjualan as ModelsItemPenjualan;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ItemPenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:produk,id', // Sesuaikan nama tabel produk (produk/produks)
            'quantity'   => 'required|integer|min:1'
        ]);

        DB::transaction(function () use ($request) {

            // 🛠️ PERBAIKAN: Gunakan firstOrCreate agar jika transaksi 'OPEN' belum ada, otomatis dibuatkan baru!
            $sale = Penjualan::firstOrCreate(
                [
                    'user_id' => Auth::id(),
                    'status'  => 'OPEN',
                ],
                [
                    'total_pembayaran' => 0,
                    'payment_method'   => null,
                ]
            );

            $product = Produk::lockForUpdate()->findOrFail($request->product_id);

            // Cek stok (ValidationException otomatis memicu ROLLBACK transaksi)
            if ($product->stok < $request->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Stok produk tidak mencukupi (Tersisa: ' . $product->stok . ')'
                ]);
            }

            // Kurangi stok produk
            $product->decrement('stok', $request->quantity);

            // Update / insert item penjualan
            $item = ItemPenjualan::where('penjualan_id', $sale->id)
                ->where('produk_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($item) {
                // UPDATE
                $item->kuantitas += $request->quantity;
            } else {
                // CREATE
                $item = new ItemPenjualan([
                    'penjualan_id' => $sale->id,
                    'produk_id'    => $product->id,
                    'kuantitas'    => $request->quantity,
                    'harga_satuan' => $product->harga_jual,
                ]);
            }

            // Hitung subtotal item
            $item->subtotal = $item->kuantitas * $item->harga_satuan;
            $item->save();

            // Hitung total pembayaran pada Penjualan
            $sale->total_pembayaran = $sale->itemPenjualan()->sum('subtotal');
            $sale->save();
        });

        // Redirect kembali ke halaman POS/Kasir
        return redirect()->route('penjualan.create')->with('success', 'Berhasil menambahkan produk ke keranjang!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(itemPenjualan $itempenjualan)
    {
        $this->authorize('delete', $itempenjualan);

        DB::transaction(function () use ($itempenjualan) {

            $produk = $itempenjualan->produk;
            $sale = $itempenjualan->penjualan;

            $produk->increment('stok', $itempenjualan->kuantitas);

            $itempenjualan->delete();

            $sale->update([
                'total_pembayaran' => $sale->$itempenjualan()->sum('subtotal')
            ]);
        });

            return back();
    }
}