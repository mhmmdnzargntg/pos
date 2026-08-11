@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('layouts.navbar')

<div class="container py-4">

    {{-- Header Ringkasan --}}
    <div class="mb-4 text-center">
        <h1 class="fw-bold mb-1">Ringkasan Hari Ini</h1>
        <p class="text-muted">{{ $tanggalHariIni->translatedFormat('d F Y') }}</p>
    </div>

    {{-- Mengecek relasi role name atau role_id milik user --}}
    @if(auth()->check() && (optional(auth()->user()->role)->name === 'admin' || auth()->user()->role_id == 1))

    {{-- Today's Sales --}}
    <div class="mb-5">
        <h4 class="fw-semibold mb-3">Today's Sales</h4>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-header bg-white border-0 text-muted small pt-3">Total Nilai Penjualan Hari Ini</div>
                    <div class="card-body pt-0">
                        <h4 class="card-title fw-bold text-primary mb-0">Rp {{ number_format($ringkasan['total_penjualan']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-header bg-white border-0 text-muted small pt-3">Jumlah Transaksi Hari Ini</div>
                    <div class="card-body pt-0">
                        <h4 class="card-title fw-bold text-primary mb-0">{{ $ringkasan['total_transaksi'] }} Transaksi</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Cash & Payment Status --}}
    <div class="mb-5">
        <h4 class="fw-semibold mb-3">Cash & Payment Status</h4>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-header bg-white border-0 text-muted small pt-3">Total Pembayaran Tunai</div>
                    <div class="card-body pt-0">
                        <h4 class="card-title fw-bold mb-0">Rp {{ number_format($ringkasan['total_cash']) }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-header bg-white border-0 text-muted small pt-3">Total Pembayaran Non-Tunai</div>
                    <div class="card-body pt-0">
                        <h4 class="card-title fw-bold mb-0">Rp {{ number_format($ringkasan['total_non_tunai']) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Critical Inventory Status --}}
    <div class="mb-5">
        <h4 class="fw-semibold mb-3">Critical Inventory Status</h4>
        <div class="row g-3">
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-header bg-white fw-semibold">Daftar Produk Stok Rendah</div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokRendah as $index => $produk)
                                <tr>
                                    <td>{{ $produkStokRendah->firstItem() + $index }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td><span class="badge text-bg-warning">{{ $produk->stok }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-3">
                                        Seluruh produk berada dalam kondisi stok aman.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($produkStokRendah->hasPages())
                    <div class="card-footer bg-white border-0 py-2">
                        {{ $produkStokRendah->links() }}
                    </div>
                    @endif
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-header bg-white fw-semibold">Produk Habis Stok</div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0 align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokHabis as $index => $produk)
                                <tr>
                                    <td>{{ $produkStokHabis->firstItem() + $index }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td><span class="badge text-bg-danger">{{ $produk->stok }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-3">
                                        Seluruh produk berada dalam kondisi stok aman.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    @if ($produkStokHabis->hasPages())
                    <div class="card-footer bg-white border-0 py-2">
                        {{ $produkStokHabis->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Best Seller Products --}}
    <div class="mb-4">
        <h4 class="fw-semibold mb-3">Best Seller Products</h4>
        <div class="card shadow-sm border-0 rounded-3">
            <div class="card-body p-0">
                <table class="table table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Stok</th>
                            <th scope="col">Unit Terjual</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($produkTerlaris as $index => $produk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produk->nama }}</td>
                            <td>{{ $produk->stok }}</td>
                            <td><span class="badge text-bg-success">{{ $produk->total_terjual }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-muted text-center py-3">
                                Belum ada data penjualan produk.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection