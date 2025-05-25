@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-success">Add New Product</h2>

    <form id="createProductForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3"><input type="text" name="name" class="form-control" placeholder="Product Name"></div>
        <div class="mb-3"><input type="number" name="price" class="form-control" placeholder="Price"></div>
        <div class="mb-3"><textarea name="description" class="form-control" placeholder="Description"></textarea></div>
        <div class="mb-3"><input type="file" name="image" class="form-control"></div>
        <div class="mb-3">
            <select name="shop_id" class="form-control">
                <option disabled selected>-- Select Shop --</option>
                @foreach($shops as $shop)
                <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <select name="status" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>
        <button class="btn btn-success">Create Product</button>
    </form>
</div>
@endsection

@section('scripts')
<script>
    $('#createProductForm').submit(function(e) {
        e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            url: "{{ route('products.store') }}",
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(res) {
                alert('Product Created Successfully');
                window.location.href = "{{ route('products') }}";
            },
            error: function(xhr) {
                alert('Error: ' + xhr.responseJSON.message);
            }
        });
    });
</script>
@endsection