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

    <label class="form-label">

        Harga Kamar

    </label>

    <div class="input-group">

        <span class="input-group-text">
            Rp
        </span>

        <input type="text"
            id="price"
            name="price"
            class="form-control"
            required>

    </div>

</div>


   <div class="mb-3">

    <label class="form-label">
        Upload Gambar Kamar
    </label>

    <input type="file"
        id="imageInput"
        name="images[]"
        multiple
        class="form-control">

</div>

<div class="row"
    id="previewContainer">

</div>


    <button class="btn btn-primary">
        Simpan
    </button>

</form>

<script>

const priceInput = document.getElementById('price');

priceInput.addEventListener('input', function(e){

    let value = this.value.replace(/\D/g, '');

    this.value = new Intl.NumberFormat('id-ID')
        .format(value);

});

</script>
<script>

let selectedFiles = [];

const imageInput = document.getElementById('imageInput');
const previewContainer = document.getElementById('previewContainer');

imageInput.addEventListener('change', function(e){

    const files = Array.from(e.target.files);

    files.forEach(file => {

        selectedFiles.push(file);

    });

    renderPreview();

});

function renderPreview(){

    previewContainer.innerHTML = '';

    const dataTransfer = new DataTransfer();

    selectedFiles.forEach((file, index) => {

        dataTransfer.items.add(file);

        const reader = new FileReader();

        reader.onload = function(e){

            previewContainer.innerHTML += `

                <div class="col-md-3 mb-3">

                    <div class="card border-0 shadow-sm">

                        <img src="${e.target.result}"
                            class="img-fluid rounded"
                            style="height:180px;object-fit:cover;">

                        <div class="card-body p-2">

                            <button type="button"
                                class="btn btn-danger btn-sm w-100"
                                onclick="removeImage(${index})">

                                Hapus

                            </button>

                        </div>

                    </div>

                </div>

            `;

        }

        reader.readAsDataURL(file);

    });

    imageInput.files = dataTransfer.files;

}

function removeImage(index){

    selectedFiles.splice(index, 1);

    renderPreview();

}

</script>

@endsection