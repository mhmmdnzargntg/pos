@extends('layouts.app')

@section('title', 'POS')

@section('content')

<h4 class="mb-3">
    Tambah dan Edit
</h4>

<div class="row">

{{-- ==================== PRODUK ==================== --}}
<div class="col-md-6">
    <div class="card">
        <div class="card-body" style="max-height: 70vh; overflow: auto">
            <div class="mb-3">
                <form method="" action="">
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="form-control"
                        placeholder="Cari produk..."
                        onkeyup="this.form.submit()">
                </form>
            </div>
                <form method="" action="" class="row mb-2">
                    @csrf
                    <input type="hidden" name="produk_id" value="">

                    <div class="col-7">
                        <button class="btn btn-primary w-100 text-start p-2">
                            <div class="d-flex align-items-center gap-2">
                                <img src=""
                                    alt="Gambar"
                                    class="rounded-circle"
                                    style="width:45px; height:45px; object-fit:cover">

                                <div>
                                    <div class="fw-semibold">Coki Coki</div>
                                    <small class="text-muted">Rp. 20.000</small>
                                </div>
                            </div>
                        </button>
                    </div>
                    <div class="col-3">
                        <input type="number"
                            name="quantity"
                            value="1"
                            min="1"
                            class="form-control">
                    </div>

                    <div class="col-2">
                        <button class="btn btn-primary w-100">+</button>
                    </div>