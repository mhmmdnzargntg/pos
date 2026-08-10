@extends('layouts.app')

@section('title', 'Penjualan')

@section('content')

@include('layouts.navbar')

{{-- Alert Pesan Error / Success --}}
@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<h1>Halaman Penjualan</h1>

<a href="{{ route('penjualan.create') }}" class="btn btn-primary mb-3">Create</a>

<form action="{{ route('penjualan.index') }}" method="GET" class="mb-3">
    <div class="input-group">
        <input 
            type="text" 
            name="search" 
            value="{{ request()->search }}" 
            class="form-control" 
            placeholder="Search penjualan"
        >
        <button class="btn btn-outline-secondary" type="submit">
            Search
        </button>
    </div>
</form>

<table class="table align-middle">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Tanggal Transaksi</th>
      <th scope="col">Kasir</th>
      <th scope="col">Total Pembayaran</th>
      <th scope="col">Metode Pembayaran</th>
      <th scope="col">Status</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    @forelse($sales as $sale)
    <tr>
        <th scope="row">{{ ($sales->firstItem() + $loop->index) }}</th>
        <td>{{ $sale->created_at->translatedFormat('d-m-Y H:i:s') }}</td>
        <td>{{ $sale->user->name }}</td>
        <td>Rp. {{ number_format($sale->total_pembayaran) }}</td>
        <td>{{ $sale->metode_pembayaran ?? '-' }}</td>
        <td>
            <span class="badge {{ $sale->status === 'COMPLETED' ? 'bg-success' : 'bg-warning' }}">
                {{ $sale->status }}
            </span>
        </td>
        <td class="d-flex gap-1 align-items-center">
            <a href="{{ route('penjualan.show', $sale->id) }}" class="btn btn-primary btn-sm">Detail</a>
            
            {{-- PERBAIKAN 1: Mengubah 'view' menjadi 'update' dan menghapus tanda petik pada $sale --}}
            @can('update', $sale)
                || 
                <a href="{{ route('penjualan.edit', $sale->id) }}" class="btn btn-warning btn-sm">Edit</a>
            @endcan

            {{-- PERBAIKAN 2: Menghapus tanda petik pada $sale --}}
            @can('delete', $sale)
                ||
                <form action="{{ route('penjualan.destroy', $sale->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin akan menghapus penjualan ini?')">
                        Hapus
                    </button>
                </form>              
            @endcan
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="7" class="text-center text-muted">Data Tidak Ditemukan</td>
    </tr>
    @endforelse
  </tbody>
</table>

{{ $sales->links() }}
@endsection