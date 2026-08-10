<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Penjualan;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PenjualanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SearchRequest $request)
    {
        $user = Auth::user();
        $keyword = $request->input('search');

        $sales = Penjualan::query()

            ->when($user->role->name === 'kasir', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })

            ->when($keyword, function ($query) use ($keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', '%' . $keyword . '%');
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('penjualan.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $sale = Penjualan::firstOrCreate(
            [
                'user_id' => Auth::id(),
                'status' => 'OPEN'
            ],
            [
                'total_pembayaran' => 0,
                'metode_pembayaran' => 'CASH'
            ]
        );

        $keyword = $request->input('search');

        $products = Produk::query()
            ->when($keyword, function ($query) use ($keyword) {
                $query->where('nama', 'like', '%' . $keyword . '%');
            })
            ->orderBy('nama')
            ->get();

        $mode = 'create';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(Penjualan $penjualan)
    {
        $sale = $penjualan;

        abort_if($sale->status === 'COMPLETED', 403);

        $sale ->load('itemPenjualan');
        $products = Produk::orderBy('nama')->get();
        $mode = 'edit';

        return view('penjualan.pos', compact('sale', 'products', 'mode'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Penjualan $penjualan)
{
    $request->validate([
        'payment_method' => 'required|in:CASH,QRIS'
    ]);

    if ($penjualan->status !== 'OPEN') {
        return back()->with('errors', 'Transaksi sudah diproses');
    }

    if ($penjualan->itemPenjualan()->count() === 0) {
        return back()->with('errors', 'Keranjang masih kosong');
    }

    DB::transaction(function () use ($penjualan, $request) {

        // Hitung ulang total (anti manipulasi)
        $total = $penjualan->itemPenjualan()->sum('subtotal');

        $penjualan->update([
            'metode_pembayaran' => $request->payment_method,
            'total_pembayaran'  => $total,
            'status'            => 'COMPLETED'
        ]);
    });

    return redirect()
        ->route('penjualan.index')
        ->with('success', 'Transaksi berhasil diselesaikan');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Penjualan $penjualan)
{
    $this->authorize('delete', $penjualan);
    
    if ($penjualan->status !== 'OPEN') {

        return redirect()->route('penjualan.index')->with('error', 'Transaksi yang sudah selesai tidak bisa dihapus!');
    }

    // ! Pastikan milik user login (kasir)
    if ($penjualan->user_id !== Auth::id()) {
        return redirect()->route('penjualan.index')->with('error', 'Akses ditolak!');
    }

    DB::transaction(function () use ($penjualan) {
        foreach ($penjualan->itemPenjualan as $item) {
            $item->produk->increment('stok', $item->kuantitas);
        }

        $penjualan->itemPenjualan()->delete();
        $penjualan->delete();
    });

    return redirect()
        ->route('penjualan.index')
        ->with('success', 'Transaksi berhasil dibatalkan');
}
}