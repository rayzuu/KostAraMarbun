@extends('layouts.admin')

@section('title', 'Tambah Kamar')

@section('page-title', 'Tambah Kamar')

@section('content')

<form action="{{ route('rooms.store') }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    <div class="mb-3">

        <label>Nama Kamar</label>

        <input type="text"
            name="name"
            class="form-control">

    </div>

    <div class="mb-3">

        <label>Deskripsi</label>

        <textarea name="description"
            class="form-control"></textarea>

    </div>

    <div class="mb-3">

        <label>Harga</label>

        <input type="number"
            name="price"
            class="form-control">

    </div>

    <div class="mb-3">

        <label>Lokasi</label>

        <input type="text"
            name="location"
            class="form-control">

    </div>

    <div class="mb-3">

    <label>Gambar Kamar</label>

    <input type="file"
        name="image"
        class="form-control">

</div>

    <button class="btn btn-primary">
        Simpan
    </button>

</form>

@endsection