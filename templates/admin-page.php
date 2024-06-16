<div class="wrap">
    <h1>SmartMail Software Store</h1>

    <!-- Display form for adding a new product -->
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
        <input type="text" name="price" id="price" required><br>
        <label for="rrp">RRP:</label>
        <input type="text" name="rrp" id="rrp" required><br>
        <label for="image">Image URL:</label>
        <input type="text" name="image_url" id="image_url"><br>
        <label for="sku">SKU:</label>
        <input type="text" name="sku" id="sku"><br>
        <label for="barcode">Barcode:</label>
        <input type="text" name="barcode" id="barcode"><br>
        <label for="quantity">Quantity:</label>
        <input type="text" name="quantity" id="quantity" required><br>
        <label for="file">File URL:</label>
        <input type="text" name="file_url" id="file_url"><br>
        <input type="submit" value="Add Product">
    </form>

    <!-- Display existing products with edit and delete options -->
    <h2>Existing Products</h2>

    <h3>eBooks</h3>
    <?php foreach ($ebooks as $ebook) : ?>
        <div>
            <h4><?php echo esc_html($ebook->title); ?></h4>
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="edit_product">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($ebook->id); ?>">
                <input type="hidden" name="product_type" value="ebook">
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo esc_attr($ebook->title); ?>"><br>
                <label for="description">Description:</label>
                <textarea name="description"><?php echo esc_textarea($ebook->description); ?></textarea><br>
                <label for="price">Price:</label>
                <input type="text" name="price" value="<?php echo esc_attr($ebook->price); ?>"><br>
                <label for="rrp">RRP:</label>
                <input type="text" name="rrp" value="<?php echo esc_attr($ebook->rrp); ?>"><br>
                <label for="image_url">Image URL:</label>
                <input type="text" name="image_url" value="<?php echo esc_attr($ebook->image_url); ?>"><br>
                <label for="sku">SKU:</label>
                <input type="text" name="sku" value="<?php echo esc_attr($ebook->sku); ?>"><br>
                <label for="barcode">Barcode:</label>
                <input type="text" name="barcode" value="<?php echo esc_attr($ebook->barcode); ?>"><br>
                <label for="quantity">Quantity:</label>
                <input type="text" name="quantity" value="<?php echo esc_attr($ebook->quantity); ?>"><br>
                <label for="file_url">File URL:</label>
                <input type="text" name="file_url" value="<?php echo esc_attr($ebook->file_url); ?>"><br>
                <input type="submit" value="Update">
            </form>

            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="delete_product">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($ebook->id); ?>">
                <input type="hidden" name="product_type" value="ebook">
                <input type="submit" value="Delete">
            </form>
        </div>
    <?php endforeach; ?>

    <h3>Software</h3>
    <?php foreach ($software as $item) : ?>
        <div>
            <h4><?php echo esc_html($item->title); ?></h4>
            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="edit_product">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($item->id); ?>">
                <input type="hidden" name="product_type" value="software">
                <label for="title">Title:</label>
                <input type="text" name="title" value="<?php echo esc_attr($item->title); ?>"><br>
                <label for="description">Description:</label>
                <textarea name="description"><?php echo esc_textarea($item->description); ?></textarea><br>
                <label for="price">Price:</label>
                <input type="text" name="price" value="<?php echo esc_attr($item->price); ?>"><br>
                <label for="rrp">RRP:</label>
                <input type="text" name="rrp" value="<?php echo esc_attr($item->rrp); ?>"><br>
                <label for="image_url">Image URL:</label>
                <input type="text" name="image_url" value="<?php echo esc_attr($item->image_url); ?>"><br>
                <label for="sku">SKU:</label>
                <input type="text" name="sku" value="<?php echo esc_attr($item->sku); ?>"><br>
                <label for="barcode">Barcode:</label>
                <input type="text" name="barcode" value="<?php echo esc_attr($item->barcode); ?>"><br>
                <label for="quantity">Quantity:</label>
                <input type="text" name="quantity" value="<?php echo esc_attr($item->quantity); ?>"><br>
                <label for="file_url">File URL:</label>
                <input type="text" name="file_url" value="<?php echo esc_attr($item->file_url); ?>"><br>
                <input type="submit" value="Update">
            </form>

            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
                <input type="hidden" name="action" value="delete_product">
                <input type="hidden" name="product_id" value="<?php echo esc_attr($item->id); ?>">
                <input type="hidden" name="product_type" value="software">
                <input type="submit" value="Delete">
            </
                              <input type="submit" value="Delete">
            </form>
        </div>
    <?php endforeach; ?>
</div>
      
