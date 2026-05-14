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

                    <input type="file" name="images[]" multiple class="form-control">

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
@endsection
