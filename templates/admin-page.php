<?php if (!defined('ABSPATH')) exit; ?>

<div class="wrap">
    <h1>SmartMail Software Store</h1>
    <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
        <input type="hidden" name="action" value="add_product">
        <table class="form-table">
            <tr valign="top">
                <th scope="row"><label for="product-type">Product Type</label></th>
                <td>
                    <select name="product_type" id="product-type">
                        <option value="ebook">eBook</option>
                        <option value="software">Software</option>
                    </select>
                </td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="title">Title</label></th>
                <td><input type="text" name="title" id="title" class="regular-text" required></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="description">Description</label></th>
                <td><textarea name="description" id="description" class="large-text" required></textarea></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="price">Price</label></th>
                <td><input type="number" name="price" id="price" class="regular-text" step="0.01" required></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="rrp">RRP</label></th>
                <td><input type="number" name="rrp" id="rrp" class="regular-text" step="0.01"></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="image-url">Image URL</label></th>
                <td><input type="url" name="image_url" id="image-url" class="regular-text" required></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="sku">SKU</label></th>
                <td><input type="text" name="sku" id="sku" class="regular-text"></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="barcode">Barcode</label></th>
                <td><input type="text" name="barcode" id="barcode" class="regular-text"></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="quantity">Quantity</label></th>
                <td><input type="number" name="quantity" id="quantity" class="regular-text" required></td>
            </tr>
            <tr valign="top">
                <th scope="row"><label for="file-url">File URL</label></th>
                <td><input type="url" name="file_url" id="file-url" class="regular-text" required></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" class="button-primary" value="Add Product"></p>
    </form>
</div>
