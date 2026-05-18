@extends('layouts.admin')

@section('title', 'Edit Kamar')

@section('page-title', 'Edit Kamar')

@section('content')

    <form action="{{ route('rooms.update', $room->id) }}" method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body">

                <div class="mb-3">

                    <label>Nama Kamar</label>

                    <input type="text" name="name" value="{{ $room->name }}" class="form-control">

                </div>

                <div class="mb-3">

                    <label>Deskripsi</label>

                    <textarea name="description" class="form-control">{{ $room->description }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">

                        Harga Kamar

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            Rp
                        </span>

                        <input type="text" id="price" name="price"
                            value="{{ number_format($room->price, 0, ',', '.') }}" class="form-control" required>

                    </div>

                </div>



                <div class="mb-3">

                    <label>Status</label>

                    <select name="status" class="form-control">

                        <option value="available" {{ $room->status == 'available' ? 'selected' : '' }}>

                            Available

                        </option>

                        <option value="booked" {{ $room->status == 'booked' ? 'selected' : '' }}>

                            Full

                        </option>

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Upload / Tambah Gambar
                    </label>

                    <input type="file" id = "imageInput" name="images[]" class="form-control" multiple accept=".jpg,.jpeg,.png">

                </div>

                @if ($room->image)
                    <img src="{{ asset('storage/' . $room->image) }}" width="200" class="rounded mb-3">
                @endif

                <button class="btn btn-primary">

                    Update Kamar

                </button>

            </div>

        </div>

    </form>
    <script>
        const priceInput = document.getElementById('price');

        priceInput.addEventListener('input', function(e) {

            let value = this.value.replace(/\D/g, '');

            this.value = new Intl.NumberFormat('id-ID')
                .format(value);

        });
    </script>

    <script>
        let selectedFiles = [];

        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');

        imageInput.addEventListener('change', function(e) {

            const files = Array.from(e.target.files);

            files.forEach(file => {

                selectedFiles.push(file);

            });

            renderPreview();

        });

        function renderPreview() {

            previewContainer.innerHTML = '';

            const dataTransfer = new DataTransfer();

            selectedFiles.forEach((file, index) => {

                dataTransfer.items.add(file);

                const reader = new FileReader();

                reader.onload = function(e) {

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

        function removeImage(index) {

            selectedFiles.splice(index, 1);

            renderPreview();

        }
    </script>
@endsection
