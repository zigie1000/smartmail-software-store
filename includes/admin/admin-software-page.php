<div class="wrap">
    <h1>Manage Software</h1>
    <a href="<?php echo admin_url('post-new.php?post_type=software'); ?>" class="page-title-action">Add New Software</a>
    <?php
    $args = array(
        'post_type' => 'software',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );
    $software = new WP_Query($args);
    if ($software->have_posts()) {
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Title</th><th>Actions</th></tr></thead>';
        echo '<tbody>';
        while ($software->have_posts()) {
            $software->the_post();
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
        echo '<p>No Software found.</p>';
    }
    wp_reset_postdata();
    ?>
</div>
