@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-primary">Edit Product</h2>

    <form id="editProductForm" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <input type="text" name="name" value="{{ $product->name }}" class="form-control">
            <span class="text-danger error-text name_error"></span>
        </div>

        <div class="mb-3">
            <input type="number" name="price" value="{{ $product->price }}" class="form-control">
            <span class="text-danger error-text price_error"></span>
        </div>

        <div class="mb-3">
            <textarea name="description" class="form-control">{{ $product->description }}</textarea>
            <span class="text-danger error-text description_error"></span>
        </div>

        <div class="mb-3">
            @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" width="100" class="mb-2">
            @endif
            <input type="file" name="image" class="form-control">
            <span class="text-danger error-text image_error"></span>
        </div>

        <div class="mb-3">
            <select name="shop_id" class="form-control">
                @foreach($shops as $shop)
                <option value="{{ $shop->id }}" {{ $shop->id == $product->shop_id ? 'selected' : '' }}>
                    {{ $shop->name }}
                </option>
                @endforeach
            </select>
            <span class="text-danger error-text shop_id_error"></span>
        </div>

        <div class="mb-3">
            <select name="status" class="form-control">
                <option value="1" {{ $product->status ? 'selected' : '' }}>Active</option>
                <option value="0" {{ !$product->status ? 'selected' : '' }}>Inactive</option>
            </select>
            <span class="text-danger error-text status_error"></span>
        </div>

        <button class="btn btn-primary">Update Product</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $('#editProductForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $('.error-text').text(''); // Clear previous errors

        $.ajax({
            url: "{{ route('products.update', $product->id) }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Product Updated Successfully',
                    confirmButtonColor: '#3085d6',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = "{{ route('products') }}";
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        $('.' + key + '_error').text(value[0]);
                    });
                } else {
                    Swal.fire('Error', 'Something went wrong!', 'error');
                }
            }
        });
    });
</script>
@endsection
