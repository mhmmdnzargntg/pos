@extends('layouts.app')

@section('title', 'Produk')

@section('content')

@include('layouts.navbar')

<h1>Halaman Produk</h1>
@can('create', App\Models\Produk::class)
<a href="{{ route('produk.create') }}" method="GET" class="btn btn-primary mb-3">Create</a>
@endcan

    <form action="{{ route('produk.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input 
                type="text"
                name="search"
                value=""
                class="form-control"
                placeholder="Search nama produk.">

            <button class="btn btn-outline-secondary" type="submit">
                Search
            </button>
        </div>
    </form>
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">User</th>
      <th scope="col">Foto</th>
      <th scope="col">Nama</th>
      <th scope="col">Harga Beli</th>
      <th scope="col">Harga Jual</th>
      <th scope="col">Stok</th>
      <th scope="col">Aksi </th>
    </tr>
  </thead>
  <tbody>
    @forelse ($products as $item)
    <tr>
        <th scope="row">{{ $products->firstItem() + $loop->index }}</th>
        <td>{{ $item->user->name }}</td>
        <td>
            <img src="{{ asset('storage/'.$item->foto) }}"
                    width="100"
                    class="img-thumbnil">
        </td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->harga_beli }}</td>
        <td>{{ $item->harga_jual }}</td>
        <td>{{ $item->stok }}</td>
        <td>
        @can('update', $item)
            <a href="{{ route('produk.edit', $item) }}" class="btn btn-warning">Edit</a>
             @endcan
            ||
            @can('delete', $item)
            <form action="{{ route('produk.destroy', $item) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger" onclick="return confirm('Apakah anda yakin menghapus user ini?')">
                    Hapus
                </button>
            </form>
        @endcan
    </td>
</tr>
    @empty
        <tr>
            <td collspan=8><h1>Data tidak tersedia.</h1></td>
        </tr>
    @endforelse
  </tbody>
</table>
{{ $products->links() }}

@endsection
