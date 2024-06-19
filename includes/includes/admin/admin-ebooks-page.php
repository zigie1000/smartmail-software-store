<div class="wrap">
    <h1>Manage eBooks</h1>
    <a href="<?php echo admin_url('post-new.php?post_type=ebook'); ?>" class="page-title-action">Add New eBook</a>
    <?php
    $args = array(
        'post_type' => 'ebook',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $ebooks = new WP_Query($args);
    if ($ebooks->have_posts()) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Title</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($ebooks->have_posts()) {
            $ebooks->the_post();
            echo '<tr>';
            echo '<td>' . get_the_title() . '</td>';
            echo '<td>';
            echo '<a href="' . get_edit_post_link() . '">Edit</a> | ';
            echo '<a href="' . get_delete_post_link() . '">Delete</a>';
            echo '</td>';
            echo '</tr>';
        }
        echo '</tbody>';
        echo '</table>';
    } else {
        echo '<p>No eBooks found.</p>';
    }
    wp_reset_postdata();
    ?>
</div>
