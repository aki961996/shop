@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Products List</h2>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addProductModal">Add Product</button>

    <table class="table table-bordered" id="productsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
              
                <th>Description</th>
                <th>Image</th>
                <th>Shop</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr data-id="{{ $product->id }}">
                <td>{{ $product->id }}</td>
                <td class="product-name">{{ $product->name }}</td>
                <td class="product-price">{{ $product->price }}</td>
             
                <td class="product-description">{{ $product->description }}</td>
                <td>
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" width="50">
                    @endif
                </td>
                <td class="product-shop">{{ $product->shop->name }}</td>
                <td class="product-status">{{ $product->status ? 'Active' : 'Inactive' }}</td>
                <td>
                    <button class="btn btn-primary btn-sm edit-product-btn"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->price }}"
                       
                        data-description="{{ $product->description }}"
                        data-shop_id="{{ $product->shop_id }}"
                        data-status="{{ $product->status }}">
                        Edit
                    </button>
                    <button class="btn btn-danger btn-sm delete-product-btn" data-id="{{ $product->id }}">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@include('admin.products.partials.add_modal')
@include('admin.products.partials.edit_modal')
@endsection

@section('scripts')
<script>
  
    var productShowUrlTemplate = "{{ route('admin.product.show', ':id') }}";
       var productUpadate = "{{ route('admin.products.update', ':id') }}";
        var productDelete = "{{ route('admin.products.delete', ':id') }}"
</script>

<script>
$(function() {
    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } });

    // Add Product
   $('#addProductForm').submit(function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    $.ajax({
        url: "{{ route('admin.products.store') }}",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function (response) {
            const product = response.product;

            $('#productsTable tbody').append(`
                <tr data-id="${product.id}">
                    <td>${product.id}</td>
                    <td class="product-name">${product.name}</td>
                    <td class="product-price">${product.price}</td>
                    <td class="product-description">${product.description ?? ''}</td>
                    <td>
                        ${product.image ? `<img src="/storage/${product.image}" width="50">` : ''}
                    </td>
                    <td class="product-shop">${product.shop_name}</td>
                    <td class="product-status">${product.status ? 'Active' : 'Inactive'}</td>
                    <td>
                        <button class="btn btn-primary btn-sm edit-product-btn"
                            data-id="${product.id}">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm delete-product-btn"
                            data-id="${product.id}">
                            Delete
                        </button>
                    </td>
                </tr>
            `);

            $('#addProductModal').modal('hide');
            $('#addProductForm')[0].reset();
            $('#addProductForm .is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        },
        error: function (xhr) {
            const errors = xhr.responseJSON.errors;
            $('#addProductForm .is-invalid').removeClass('is-invalid');
            $('.invalid-feedback').text('');

            for (const key in errors) {
                const capitalKey = key.charAt(0).toUpperCase() + key.slice(1);
                $(`#product${capitalKey}`).addClass('is-invalid');
                $(`#add${capitalKey}Error`).text(errors[key][0]);
            }
        }
    });
});


    // Edit Product - Show Modal with Values
 
    
$(document).on('click', '.edit-product-btn', function () {
    const btn = $(this);
    const productId = btn.data('id');

    // Replace ':id' in URL template with actual productId
    const url = productShowUrlTemplate.replace(':id', productId);

    $.ajax({
        url: url,
        type: 'GET',
        dataType: 'json',
        success: function(product) {
            $('#editProductId').val(product.id);
            $('#editProductName').val(product.name);
            $('#editProductPrice').val(product.price);
         
            $('#editProductDescription').val(product.description);
            $('#editProductShopId').val(product.shop_id);
            $('#editProductStatus').val(product.status);

            const imageUrl = product.image ? `/storage/${product.image}` : 'https://via.placeholder.com/120';
            $('#editImagePreview').attr('src', imageUrl);

            const modal = new bootstrap.Modal(document.getElementById('editProductModal'));
            modal.show();

            $('#editProductForm input, textarea, select').removeClass('is-invalid');
            $('.invalid-feedback').text('');
        },
        error: function(xhr, status, error) {
            alert('Failed to fetch product data.');
            console.error(error);
        }
    });
});




    // Update Product
  $('#editProductForm').submit(function(e) {
    e.preventDefault();
    const productId = $('#editProductId').val();
    let formData = new FormData(this);
    const url = productUpadate.replace(':id', productId);

    $.ajax({
        url: url,
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            const product = response.product;
            let row = $(`#productsTable tbody tr[data-id="${productId}"]`);
            row.find('.product-name').text(product.name);
            row.find('.product-price').text(product.price);
            row.find('.product-description').text(product.description);
            row.find('.product-shop').text(product.shop_name);
            row.find('.product-status').text(product.status ? 'Active' : 'Inactive');
            row.find('img').attr('src', product.image ? `/storage/${product.image}` : '');
            $('#editProductModal').modal('hide');
            // ✅ Refresh 
   location.reload();
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            for (const key in errors) {
                $(`#editProduct${key.charAt(0).toUpperCase() + key.slice(1)}`).addClass('is-invalid');
                $(`#edit${key.charAt(0).toUpperCase() + key.slice(1)}Error`).text(errors[key][0]);
            }
        }
    });
});


    // Delete Product
   $(document).on('click', '.delete-product-btn', function() {
    if (!confirm('Are you sure?')) return;

    const productId = $(this).data('id');
    const url = productDelete.replace(':id', productId);

    $.ajax({
        url: url,
        type: 'DELETE',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content') // important for DELETE
        },
        success: function(response) {
            if (response.success) {
                $(`#productsTable tbody tr[data-id="${productId}"]`).remove();
            }
        },
        error: function(xhr) {
            alert('Something went wrong.');
            console.error(xhr.responseText);
        }
    });
});

});
</script>
@endsection
