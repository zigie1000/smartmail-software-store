<div class="wrap">
    <h1>Manage eBooks</h1>
    <a href="<?php echo admin_url('post-new.php?post_type=ebook'); ?>" class="page-title-action">Add New eBook</a>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Date</th>
                <th scope="col">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $ebooks = get_posts(array('post_type' => 'ebook', 'numberposts' => -1));
                if ($ebooks) {
                    foreach ($ebooks as $ebook) {
                        echo '<tr>';
                        echo '<td>' . esc_html($ebook->post_title) . '</td>';
                        echo '<td>' . esc_html(get_the_author_meta('display_name', $ebook->post_author)) . '</td>';
                        echo '<td>' . esc_html(get_the_date('', $ebook)) . '</td>';
                        echo '<td>
                                <a href="' . get_edit_post_link($ebook->ID) . '">Edit</a> |
                                <a href="' . get_delete_post_link($ebook->ID) . '">Delete</a>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No eBooks found.</td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>
