@extends('layouts.app')

@section('content')
<div class="container py-4">
    <h2 class="mb-4 text-success">Add New Product</h2>

    <form id="createProductForm" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
    <input type="text" name="name" class="form-control" placeholder="Product Name">
    <div class="text-danger" id="error-name"></div>
</div>
       <div class="mb-3">
    <input type="number" name="price" class="form-control" placeholder="Price">
    <div class="text-danger" id="error-price"></div>
</div>
     <div class="mb-3">
    <textarea name="description" class="form-control" placeholder="Description"></textarea>
    <div class="text-danger" id="error-description"></div>
</div>
       <div class="mb-3">
    <input type="file" name="image" class="form-control">
    <div class="text-danger" id="error-image"></div>
</div>
      <div class="mb-3">
    <select name="shop_id" class="form-control">
        <option disabled selected>-- Select Shop --</option>
        @foreach($shops as $shop)
        <option value="{{ $shop->id }}">{{ $shop->name }}</option>
        @endforeach
    </select>
    <div class="text-danger" id="error-shop_id"></div>
</div>

<div class="mb-3">
    <select name="status" class="form-control">
        <option value="1">Active</option>
        <option value="0">Inactive</option>
    </select>
    <div class="text-danger" id="error-status"></div>
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

    // Clear previous errors
    $('.text-danger').text('');

    $.ajax({
        url: "{{ route('products.store') }}",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(res) {
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'Product Created Successfully',
                confirmButtonColor: '#3085d6',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.href = "{{ route('products') }}";
            });
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    $('#error-' + key).text(value[0]);
                });
            } else {
                alert('Error: ' + xhr.responseJSON.message);
            }
        }
    });
});

</script>
@endsection