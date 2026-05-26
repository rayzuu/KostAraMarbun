@extends('layouts.admin')

@section('title', 'Edit Kamar')

@section('page-title', 'Edit Kamar')

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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

                    <label>Kapasitas Kamar</label>

                    <input type="number" name="kapasitas" class="form-control"
                        value="{{ old('kapasitas', $room->kapasitas ?? 6) }}">

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
                    <label class="form-label">Upload Gambar Kamar</label>


                    <div id="alertContainer"></div>

                    <input type="file" id="imageInput" name="images[]" class="form-control" multiple
                        accept=".jpg,.jpeg,.png,.webp">
                    <small class="text-muted">Format File: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</small>
                </div>
                <div class="row mt-3">

                    <div id="oldImageContainer" class="row">

                        @foreach ($room->images as $image)
                            <div class="col-md-3 mb-3 image-old-wrapper">

                                <div class="card border-0 shadow-sm position-relative">

                                    <img src="{{ asset('storage/' . $image->image) }}" class="img-fluid rounded"
                                        style="height:180px;object-fit:cover;">

                                    <button type="button"
                                        class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 rounded-circle remove-old-image"
                                        data-id="{{ $image->id }}">

                                        <i class="fa-solid fa-times"></i>

                                    </button>

                                </div>

                            </div>
                        @endforeach

                    </div>

                </div>

                <div id="deletedImagesContainer"></div>
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
        const alertContainer = document.getElementById('alertContainer');

        imageInput.addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            let hasInvalidFile = false;


            alertContainer.innerHTML = '';

            files.forEach(file => {

                if (!allowedTypes.includes(file.type)) {
                    hasInvalidFile = true;
                    return;
                }

                if (file.size > 2 * 1024 * 1024) {
                    showAlert(`File "${file.name}" Maksimal ukuran adalah 2MB.`, 'warning');
                    return;
                }

                selectedFiles.push(file);
            });

            if (hasInvalidFile) {
                showAlert('File Bukan Gambar (Wajib JPG, JPEG, PNG, atau WEBP)!.', 'danger');
            }

            renderPreview();
        });

        function showAlert(message, type) {
            alertContainer.innerHTML = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;
        }

        function renderPreview() {
            previewContainer.innerHTML = '';
            const dataTransfer = new DataTransfer();

            selectedFiles.forEach((file, index) => {
                dataTransfer.items.add(file);

                const reader = new FileReader();
                reader.onload = function(e) {
                    const col = document.createElement('div');
                    col.className = 'col-md-3 mb-3';
                    col.innerHTML = `
                        <div class="card border-0 shadow-sm position-relative">
                            <img src="${e.target.result}" class="img-fluid rounded" style="height:180px; width:100%; object-fit:cover;">
                            <div class="card-body p-2">
                                <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeImage(${index})">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    `;
                    previewContainer.appendChild(col);
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

    <script>
        const deletedImagesContainer = document.getElementById(
            'deletedImagesContainer'
        );

        document.querySelectorAll('.remove-old-image')
            .forEach(button => {

                button.addEventListener('click', function() {

                    const imageId = this.dataset.id;

                    // HAPUS CARD DARI UI
                    this.closest('.image-old-wrapper').remove();

                    // BUAT INPUT HIDDEN
                    const hiddenInput = document.createElement('input');

                    hiddenInput.type = 'hidden';

                    hiddenInput.name = 'delete_images[]';

                    hiddenInput.value = imageId;

                    deletedImagesContainer.appendChild(hiddenInput);

                    console.log('DELETE IMAGE ID:', imageId);

                });

            });
    </script>
@endsection
