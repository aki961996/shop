<!-- Edit Product Modal -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="editProductForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editProductId">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" name="name" id="editProductName">
                    <div class="invalid-feedback" id="editNameError"></div>

                    <input type="number" step="0.01" class="form-control mb-2" name="price" id="editProductPrice">
                    <div class="invalid-feedback" id="editPriceError"></div>

                   

                    <textarea class="form-control mb-2" name="description" id="editProductDescription"></textarea>
                    <div class="invalid-feedback" id="editDescriptionError"></div>

                    <select name="shop_id" id="editProductShopId" class="form-control mb-2">
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="editShopError"></div>

                  <!-- Image Preview -->
<div class="mb-2">
    <label>Current Image:</label><br>
    <img id="editImagePreview" src="" alt="Product Image" class="img-thumbnail" width="120">
</div>

<!-- New Image Input -->
<input type="file" class="form-control mb-2" name="image" id="editProductImage">
<div class="invalid-feedback" id="editImageError"></div>

                    <select name="status" id="editProductStatus" class="form-control mb-2">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <div class="invalid-feedback" id="editStatusError"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Product</button>
                </div>
            </div>
        </form>
    </div>
</div>
