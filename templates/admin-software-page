<div class="wrap">
    <h1>Manage Software</h1>
    <a href="<?php echo admin_url('post-new.php?post_type=software'); ?>" class="page-title-action">Add New Software</a>
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
                $software_posts = get_posts(array('post_type' => 'software', 'numberposts' => -1));
                if ($software_posts) {
                    foreach ($software_posts as $software) {
                        echo '<tr>';
                        echo '<td>' . esc_html($software->post_title) . '</td>';
                        echo '<td>' . esc_html(get_the_author_meta('display_name', $software->post_author)) . '</td>';
                        echo '<td>' . esc_html(get_the_date('', $software)) . '</td>';
                        echo '<td>
                                <a href="' . get_edit_post_link($software->ID) . '">Edit</a> |
                                <a href="' . get_delete_post_link($software->ID) . '">Delete</a>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="4">No Software found.</td></tr>';
                }
            ?>
        </tbody>
    </table>
</div>
