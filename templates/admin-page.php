<div class="wrap">
    <h1>SmartMail Software Store</h1>

    <h2>Add New Product</h2>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="action" value="add_product">
        <label for="product_type">Product Type:</label>
        <select name="product_type" id="product_type">
            <option value="ebook">eBook</option>
            <option value="software">Software</option>
        </select><br>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required><br>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea><br>
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" id="price" required><br>
        <label for="rrp">RRP:</label>
        <input type="number" step="0.01" name="rrp" id="rrp" required><br>
        <label for="image_url">Image URL:</label>
        <input type="text" name="image_url" id="image_url"><br>
        <label for="sku">SKU:</label>
        <input type="text" name="sku" id="sku"><br>
        <label for="barcode">Barcode:</label>
        <input type="text" name="barcode" id="barcode"><br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" id="quantity"><br>
        <label for="file_url">File URL:</label>
        <input type="text" name="file_url" id="file_url" required><br>
        <input type="submit" value="Add Product">
    </form>
</div>
