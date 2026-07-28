@csrf

<div class="mb-3">
    <label class="form-label">Nama</label>
    <input type="text" name="name"
    class="form-control @error('name') is-invalid @enderror"
    value="{{ old('name') }}">
@error('name')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror
</div>

<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email"
        class="form-control @error('email') is-invalid @enderror"
        value="{{ old('email') }}">
@error('email')
    <div class="invalid-feedback">
        {{ $message }}
    </div>
@enderror

<div class="mb-3">
    <label class="form-label">Password</label>
    <input type="password" name="password" class="form-control">
</div>

<div class="mb-3">
    <label class="form-label">Role</label>
    <select name="role_id" class="form-select">
        <option value="">-- Pilih Role --</option>
    </select>
</div>

<button type="submit" class="btn btn-success">Simpan</button>
<a href="{{ route('admin.users') }}" class="btn btn-secondary">Kembali</a>