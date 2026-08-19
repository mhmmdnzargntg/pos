@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')

@include('layouts.navbar')

<div class="container py-4">

    <div class="mb-4 pb-2 border-bottom">
        <h1 class="h4 fw-semibold mb-1">Dashboard</h1>
        <p class="text-muted small mb-0">
            Ringkasan Hari Ini — {{ $tanggalHariIni->translatedFormat('l, d F Y') }}
        </p>
    </div>

    <div class="row g-3">
        @can('viewAny', App\Models\User::class)
        <div class="col-12">
            <h6 class="fw-semibold text-muted text-uppercase small mb-2">Today's Sale</h6>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                         style="width: 44px; height: 44px; background-color:#eef2ff;">
                        <i class="bi bi-cash-stack text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase mb-1">Total Nilai Penjualan Hari Ini</div>
                        <div class="fs-5 fw-semibold">Rp {{ number_format($ringkasan['total_penjualan']) }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                         style="width: 44px; height: 44px; background-color:#eef2ff;">
                        <i class="bi bi-card-text text-primary"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase mb-1">Jumlah Transaksi Hari Ini</div>
                        <div class="fs-5 fw-semibold">{{ $ringkasan['total_transaksi'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <h6 class="fw-semibold text-muted text-uppercase small mb-2">Cash & Payment Status</h6>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                         style="width: 44px; height: 44px; background-color:#ecfdf5;">
                        <i class="bi bi-wallet2 text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase mb-1">Total Pembayaran Tunai</div>
                        <div class="fs-5 fw-semibold">{{ $ringkasan['total_transaksi'] }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3 d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                         style="width: 44px; height: 44px; background-color:#ecfdf5;">
                        <i class="bi bi-credit-card text-success"></i>
                    </div>
                    <div>
                        <div class="text-muted small text-uppercase mb-1">Total Pembayaran Non-Tunai</div>
                        <div class="fs-5 fw-semibold">Rp {{ number_format($ringkasan['total_non_tunai']) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endcan

        <div class="col-12 mt-4">
            <h6 class="fw-semibold text-muted text-uppercase small mb-2">Critical Inventory Status</h6>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-3">Daftar Produk Stok Rendah</h6>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr class="text-muted small text-uppercase">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col" class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokRendah as $index => $produk)
                                <tr>
                                    <td>{{ $produkStokRendah->firstItem() + $index }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill" style="background-color:#fef3c7; color:#92400e;">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-3">Seluruh produk dalam kondisi stok aman.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $produkStokRendah->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-3">
                    <h6 class="fw-semibold mb-3">Produk Habis Stok</h6>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr class="text-muted small text-uppercase">
                                    <th scope="col">No</th>
                                    <th scope="col">Nama</th>
                                    <th scope="col" class="text-center">Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkStokHabis as $index => $produk)
                                <tr>
                                    <td>{{ $produkStokHabis->firstItem() + $index }}</td>
                                    <td>{{ $produk->nama }}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill" style="background-color:#fee2e2; color:#991b1b;">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-muted text-center py-3">Seluruh produk dalam kondisi stok aman.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $produkStokHabis->links() }}
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 mt-4">
            <h6 class="fw-semibold text-muted text-uppercase small mb-2">Best Seller Produk</h6>
        </div>
        <div class="col-12">
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr class="text-muted small text-uppercase">
                                    <th scope="col" class="ps-3">Nama</th>
                                    <th scope="col" class="text-center">Stok</th>
                                    <th scope="col" class="text-center">Unit Terjual</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($produkTerlaris as $produk)
                                <tr>
                                    <td class="ps-3 fw-medium">{{ $produk->nama }}</td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill" style="background-color:#f1f5f9; color:#475569;">
                                            {{ $produk->stok }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge rounded-pill" style="background-color:#ecfdf5; color:#065f46;">
                                            {{ $produk->total_terjual }}
                                        </span>
                                    </td>
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
                </div>
            </div>
        </div>

    </div>
</div>

@endsection