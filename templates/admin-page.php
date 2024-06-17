<div class="wrap">
    <h1>SmartMail Software Store</h1>
    <h2>Add New Product</h2>
    <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
        <input type="hidden" name="action" value="add_product">
        <table class="form-table">
            <tr>
                <th scope="row"><label for="product_type">Product Type</label></th>
                <td>
                    <select name="product_type" id="product_type" required>
                        <option value="ebook">eBook</option>
                        <option value="software">Software</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th scope="row"><label for="title">Title</label></th>
                <td><input name="title" type="text" id="title" value="" class="regular-text" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="description">Description</label></th>
                <td><textarea name="description" id="description" class="regular-text" required></textarea></td>
            </tr>
            <tr>
                <th scope="row"><label for="price">Price</label></th>
                <td><input name="price" type="number" step="0.01" id="price" value="" class="regular-text" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="rrp">RRP</label></th>
                <td><input name="rrp" type="number" step="0.01" id="rrp" value="" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="image_url">Image URL</label></th>
                <td><input name="image_url" type="url" id="image_url" value="" class="regular-text" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="sku">SKU</label></th>
                <td><input name="sku" type="text" id="sku" value="" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="barcode">Barcode</label></th>
                <td><input name="barcode" type="text" id="barcode" value="" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="quantity">Quantity</label></th>
                <td><input name="quantity" type="number" id="quantity" value="" class="regular-text"></td>
            </tr>
            <tr>
                <th scope="row"><label for="file_url">File URL</label></th>
                <td><input name="file_url" type="url" id="file_url" value="" class="regular-text" required></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" class="button-primary" value="Add Product"></p>
    </form>

    <h2>Existing Products</h2>
    <table class="widefat fixed" cellspacing="0">
        <thead>
            <tr>
                <th id="columnname" class="manage-column column-columnname" scope="col">ID</th>
                <th id="columnname" class="manage-column column-columnname" scope="col">Title</th>
                <th id="columnname" class="manage-column column-columnname" scope="col">Type</th>
                <th id="columnname" class="manage-column column-columnname" scope="col">Price</th>
                <th id="columnname" class="manage-column column-columnname" scope="col">Quantity</th>
                <th id="columnname" class="manage-column column-columnname" scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ebooks as $ebook): ?>
            <tr>
                <td><?php echo esc_html($ebook->id); ?></td>
                <td><?php echo esc_html($ebook->title); ?></td>
                <td>eBook</td>
                <td><?php echo esc_html($ebook->price); ?></td>
                <td><?php echo esc_html($ebook->quantity); ?></td>
                <td>
                    <a href="<?php echo esc_url(admin_url('admin-post.php?action=edit_product&id=' . $ebook->id . '&type=ebook')); ?>">Edit</a> | 
                    <a href="<?php echo esc_url(admin_url('admin-post.php?action=delete_product&id=' . $ebook->id . '&type=ebook')); ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php foreach ($software as $item): ?>
            <tr>
                <td><?php echo esc_html($item->id); ?></td>
                <td><?php echo esc_html($item->title); ?></td>
                <td>Software</td>
                <td><?php echo esc_html($item->price); ?></td>
                <td><?php echo esc_html($item->quantity); ?></td>
                <td>
                    <a href="<?php echo esc_url(admin_url('admin-post.php?action=edit_product&id=' . $item->id . '&type=software')); ?>">Edit</a> | 
                    <a href="<?php echo esc_url(admin_url('admin-post.php?action=delete_product&id=' . $item->id . '&type=software')); ?>">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
