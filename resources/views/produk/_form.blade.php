@csrf

{{-- Foto Saat Ini (Jika Mode Edit & Foto Ada) --}}
@if (!empty($produk->foto))
    <div class="mb-2">
        <label>Foto Saat Ini</label><br>
        <img src="{{ asset('storage/' . $produk->foto) }}"
            width="150"
            class="img-thumbnail">
    </div>
@endif {{-- Perbaikan dari $endif --}}

{{-- Upload Gambar & Preview --}}
<div class="row">
    <div class="col">
        <div>
            <label>Gambar Baru</label>
            <input type="file"
                name="foto"
                onchange="previewImage(this)"
                class="form-control @error('foto') is-invalid @enderror">
            @error('foto')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="col">
        <div class="mb-2">
            <label>Preview Foto Baru</label><br>
            <img id="preview" class="img-thumbnail mt-2" style="display:none" width="150">
        </div>
    </div>
</div>

{{-- Nama Produk --}}
<div class="mt-2">
    <label>Nama Produk</label><br>
    <input type="text" name="name"
        class="form-control @error('name') is-invalid @enderror"
        value="{{ old('name', $produk->nama ?? '') }}">
    @error('name')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- Harga Beli --}}
<div class="mt-2">
    <label>Harga Beli</label><br>
    <input type="number" name="purchase_price"
        class="form-control @error('purchase_price') is-invalid @enderror"
        value="{{ old('purchase_price', $produk->harga_beli ?? '') }}">
    @error('purchase_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- Harga Jual --}}
<div class="mt-2">
    <label>Harga Jual</label><br>
    <input type="number" name="selling_price"
        class="form-control @error('selling_price') is-invalid @enderror"
        value="{{ old('selling_price', $produk->harga_jual ?? '') }}">
    @error('selling_price')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

{{-- Stok --}}
<div class="mt-2">
    <label>Stok</label><br>
    <input type="number" name="stock" 
        class="form-control @error('stock') is-invalid @enderror"
        value="{{ old('stock', $produk->stok ?? '') }}">
    @error('stock')
        <div class="invalid-feedback">
            {{ $message }}
        </div>
    @enderror
</div>

<button class="btn btn-success mt-3" type="submit">Simpan</button>
<a href="{{ route('admin.produk.index') }}" class="btn btn-secondary mt-3">Kembali</a>

<script>
    function previewImage(input) {
        const preview = document.getElementById('preview');
        // Perbaikan: gunakan input.files (pakai s)
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
            preview.style.display = 'block';
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>