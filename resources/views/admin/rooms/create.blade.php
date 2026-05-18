@extends('layouts.admin')

@section('title', 'Tambah Kamar')

@section('page-title', 'Tambah Kamar')

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

    <form action="{{ route('rooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Kamar</label>
            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Harga Kamar</label>
            <div class="input-group">
                <span class="input-group-text">Rp</span>
                <input type="text" id="price" name="price" class="form-control" value="{{ old('price') }}"
                    required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Upload Gambar Kamar</label>


            <div id="alertContainer"></div>

            <input type="file" id="imageInput" name="images[]" class="form-control" multiple
                accept=".jpg,.jpeg,.png,.webp">
            <small class="text-muted">Format File: JPG, JPEG, PNG, WEBP. Maksimal 2MB.</small>
        </div>

        <div class="row" id="previewContainer"></div>

        <button type="submit" class="btn btn-primary px-4">Simpan</button>
    </form>


    <script>
        const priceInput = document.getElementById('price');
        priceInput.addEventListener('input', function(e) {
            let value = this.value.replace(/\D/g, '');
            this.value = new Intl.NumberFormat('id-ID').format(value);
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

@endsection
