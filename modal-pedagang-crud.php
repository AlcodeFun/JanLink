<!-- product_modal.php -->

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"><?php echo $title; ?></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <form id="productForm">
                <div class="form-group">
                    <label for="productName">Product Name</label>
                    <input type="text" class="form-control" id="productName" name="nama_produk" value="<?php echo isset($productData['nama_produk']) ? $productData['nama_produk'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="productDescription">Description</label>
                    <textarea class="form-control" id="productDescription" name="deskripsi"><?php echo isset($productData['deskripsi']) ? $productData['deskripsi'] : ''; ?></textarea>
                </div>
                <div class="form-group">
                    <label for="productPrice">Price</label>
                    <input type="text" class="form-control" id="productPrice" name="harga" value="<?php echo isset($productData['harga']) ? $productData['harga'] : ''; ?>" required>
                </div>
                <div class="form-group">
                    <label for="merchantID">Merchant ID</label>
                    <input type="text" class="form-control" id="merchantID" name="ID_Pedagang" value="<?php echo isset($productData['ID_Pedagang']) ? $productData['ID_Pedagang'] : ''; ?>" required>
                </div>
                <!-- Add input for thumbnail if needed -->
                <div class="form-group">
                    <label for="productThumbnail">Thumbnail</label>
                    <input type="file" class="form-control-file" id="productThumbnail" name="thum_produk">
                </div>
                <input type="hidden" name="ID_Product" value="<?php echo isset($productData['ID_Product']) ? $productData['ID_Product'] : ''; ?>">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="saveProduct()">Save changes</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Function to handle Save Changes button click
    function saveProduct() {
        var formData = $('#productForm').serializeArray();

        // Implement AJAX call to add or update the product
        $.ajax({
            url: 'server-pedagang.php',
            type: 'POST',
            data: JSON.stringify(Object.fromEntries(formData)),
            contentType: 'application/json',
            success: function(response) {
                alert(response.message);
                $('#productModal').modal('hide');
                loadProducts(); // Reload the table after adding or updating
            },
            error: function(error) {
                console.log(error);
            }
        });
    }
</script>