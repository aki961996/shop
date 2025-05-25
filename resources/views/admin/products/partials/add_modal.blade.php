<!-- Add Product Modal -->
<div class="modal fade" id="addProductModal" tabindex="-1">
    <div class="modal-dialog">
        <form id="addProductForm" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control mb-2" name="name" placeholder="Name" id="productName">
                    <div class="invalid-feedback" id="addNameError"></div>

                    <input type="number" step="0.01" class="form-control mb-2" name="price" placeholder="Price" id="productPrice">
                    <div class="invalid-feedback" id="addPriceError"></div>

                   

                    <textarea class="form-control mb-2" name="description" placeholder="Description" id="productDescription"></textarea>
                    <div class="invalid-feedback" id="addDescriptionError"></div>

                    <input type="file" class="form-control mb-2" name="image" id="productImage">
                    <div class="invalid-feedback" id="addImageError"></div>

                    <select name="shop_id" id="productShopId" class="form-control mb-2">
                        @foreach($shops as $shop)
                            <option value="{{ $shop->id }}">{{ $shop->name }}</option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback" id="addShopError"></div>

                    <select name="status" id="productStatus" class="form-control mb-2">
                        <option value="1" selected>Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <div class="invalid-feedback" id="addStatusError"></div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Add Product</button>
                </div>
            </div>
        </form>
    </div>
</div>

