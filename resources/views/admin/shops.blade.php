@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Shops List</h2>

    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addShopModal">Add Shop</button>

    <table class="table table-bordered" id="shopsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Address</th>
                <th>Email</th>
                <th>Phone</th>
              
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($shops as $shop)
            <tr data-id="{{ $shop->id }}">
                <td>{{ $shop->id }}</td>
                <td class="shop-name">{{ $shop->name }}</td>
                <td class="shop-address">{{ $shop->address }}</td>
                <td class="shop-email">{{ $shop->email }}</td>
                <td class="shop-phone">{{ $shop->phone }}</td>
              
                <td>
                    <button class="btn btn-primary btn-sm edit-btn"
                        data-id="{{ $shop->id }}"
                        data-name="{{ $shop->name }}"
                        data-description="{{ $shop->description }}"
                        data-address="{{ $shop->address }}"
                        data-phone="{{ $shop->phone }}"
                        data-email="{{ $shop->email }}"
                     >
                        Edit
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add Shop Modal -->
<div class="modal fade" id="addShopModal" tabindex="-1" aria-labelledby="addShopLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="addShopForm">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addShopLabel">Add New Shop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="shopName" class="form-label">Shop Name</label>
                        <input type="text" class="form-control" id="shopName" name="name" >
                        <div class="invalid-feedback" id="addNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="shopAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="shopAddress" name="address"></textarea>
                        <div class="invalid-feedback" id="addAddressError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="shopDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="shopDescription" name="description"></textarea>
                        <div class="invalid-feedback" id="addDescriptionError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="shopPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="shopPhone" name="phone">
                        <div class="invalid-feedback" id="addPhoneError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="shopEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="shopEmail" name="email">
                        <div class="invalid-feedback" id="addEmailError"></div>
                    </div>
                   

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Shop</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Edit Shop Modal -->
<div class="modal fade" id="editShopModal" tabindex="-1" aria-labelledby="editShopLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editShopForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="editShopId" name="id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editShopLabel">Edit Shop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <div class="mb-3">
                        <label for="editShopName" class="form-label">Shop Name</label>
                        <input type="text" class="form-control" id="editShopName" name="name" required>
                        <div class="invalid-feedback" id="editNameError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editShopAddress" class="form-label">Address</label>
                        <textarea class="form-control" id="editShopAddress" name="address"></textarea>
                        <div class="invalid-feedback" id="editAddressError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editShopDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editShopDescription" name="description"></textarea>
                        <div class="invalid-feedback" id="editDescriptionError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editShopPhone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="editShopPhone" name="phone">
                        <div class="invalid-feedback" id="editPhoneError"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editShopEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editShopEmail" name="email">
                        <div class="invalid-feedback" id="editEmailError"></div>
                    </div>
                 

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Shop</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Setup CSRF for AJAX
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

      
        $('#addShopForm').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            $('.invalid-feedback').text('');
            form.find('input,textarea').removeClass('is-invalid');

            $.ajax({
                url: "{{ route('admin.shops.store') }}",
                method: "POST",
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#addShopModal').modal('hide');

                        let shop = response.shop;
                        let newRow = `
                        <tr data-id="${shop.id}">
                            <td>${shop.id}</td>
                            <td class="shop-name">${shop.name}</td>
                            <td class="shop-address">${shop.address}</td>
                            <td class="shop-email">${shop.email}</td>
                            <td class="shop-phone">${shop.phone}</td>
                          
                            <td>
                                <button class="btn btn-primary btn-sm edit-btn"
                                    data-id="${shop.id}"
                                    data-name="${shop.name}"
                                    data-description="${shop.description}"
                                    data-address="${shop.address}"
                                    data-phone="${shop.phone}"
                                    data-email="${shop.email}"
                                    >
                                    Edit
                                </button>
                            </td>
                        </tr>
                        `;
                        $('#shopsTable tbody').append(newRow);
                          location.reload();
                        form[0].reset();
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#shopName').addClass('is-invalid');
                            $('#addNameError').text(errors.name[0]);
                        }
                        if (errors.address) {
                            $('#shopAddress').addClass('is-invalid');
                            $('#addAddressError').text(errors.address[0]);
                        }
                        if (errors.description) {
                            $('#shopDescription').addClass('is-invalid');
                            $('#addDescriptionError').text(errors.description[0]);
                        }
                        if (errors.phone) {
                            $('#shopPhone').addClass('is-invalid');
                            $('#addPhoneError').text(errors.phone[0]);
                        }
                        if (errors.email) {
                            $('#shopEmail').addClass('is-invalid');
                            $('#addEmailError').text(errors.email[0]);
                        }
                    }
                }
            });
        });

        // Open Edit Modal & fill form
       $(document).on('click', '.edit-btn', function() {
    let button = $(this);

    $('#editShopId').val(button.data('id'));
    $('#editShopName').val(button.data('name'));
    $('#editShopDescription').val(button.data('description'));
    $('#editShopAddress').val(button.data('address'));  
    $('#editShopPhone').val(button.data('phone'));
    $('#editShopEmail').val(button.data('email'));

    $('#editShopStatus').prop('checked', button.data('status') == 1);

    // Show modal using Bootstrap 5 method
    const modal = new bootstrap.Modal(document.getElementById('editShopModal'));
    modal.show();

    // Clear errors
    $('#editNameError').text('');
    $('#editDescriptionError').text('');
    $('#editAddressError').text('');
    $('#editPhoneError').text('');
    $('#editEmailError').text('');
    $('#editShopForm input, #editShopForm textarea').removeClass('is-invalid');
});


        // Edit Shop AJAX submit
        $('#editShopForm').submit(function(e) {
            e.preventDefault();
            let form = $(this);
            let shopId = $('#editShopId').val();
            $('.invalid-feedback').text('');
            form.find('input,textarea').removeClass('is-invalid');

            $.ajax({
                url: "/admin/shops/" + shopId,
                method: "POST", // Using POST with _method=PUT
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#editShopModal').modal('hide');

                        let shop = response.shop;
                        let row = $('#shopsTable tbody').find(`tr[data-id="${shopId}"]`);

                        // Update table text cells
                        row.find('.shop-name').text(shop.name);
                        row.find('.shop-address').text(shop.address);
                        row.find('.shop-email').text(shop.email);
                        row.find('.shop-phone').text(shop.phone);
                        row.find('.shop-status').text(shop.status ? 'Active' : 'Inactive');

                        // Update data attributes of Edit button for future edits
                        let btn = row.find('.edit-btn');
                        btn.data('name', shop.name);
                        btn.data('description', shop.description);
                        btn.data('address', shop.address);
                        btn.data('phone', shop.phone);
                        btn.data('email', shop.email);
                        btn.data('status', shop.status);
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        if (errors.name) {
                            $('#editShopName').addClass('is-invalid');
                            $('#editNameError').text(errors.name[0]);
                        }
                        if (errors.address) {
                            $('#editShopAddress').addClass('is-invalid');
                            $('#editAddressError').text(errors.address[0]);
                        }
                        if (errors.description) {
                            $('#editShopDescription').addClass('is-invalid');
                            $('#editDescriptionError').text(errors.description[0]);
                        }
                        if (errors.phone) {
                            $('#editShopPhone').addClass('is-invalid');
                            $('#editPhoneError').text(errors.phone[0]);
                        }
                        if (errors.email) {
                            $('#editShopEmail').addClass('is-invalid');
                            $('#editEmailError').text(errors.email[0]);
                        }
                    }
                }
            });
        });
    });
</script>
@endsection
