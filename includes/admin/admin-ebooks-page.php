<div class="wrap">
    <h1>Manage eBooks</h1>
    <a href="<?php echo admin_url('post-new.php?post_type=ebook'); ?>" class="page-title-action">Add New eBook</a>
    <hr class="wp-header-end">
    <?php
    $args = array(
        'post_type' => 'ebook',
        'posts_per_page' => -1
    );
    $ebooks = new WP_Query($args);
    if ($ebooks->have_posts()) {
        echo '<table class="widefat fixed" cellspacing="0">';
        echo '<thead><tr><th class="manage-column column-title">Title</th><th class="manage-column column-author">Author</th><th class="manage-column column-date">Date</th><th class="manage-column column-thumbnail">Thumbnail</th></tr></thead>';
        echo '<tbody>';
        while ($ebooks->have_posts()) {
            $ebooks->the_post();
            echo '<tr>';
            echo '<td class="column-title"><strong><a class="row-title" href="' . get_edit_post_link() . '">' . get_the_title() . '</a></strong></td>';
            echo '<td class="column-author">' . get_the_author() . '</td>';
            echo '<td class="column-date">' . get_the_date() . '</td>';
            echo '<td class="column-thumbnail">' . get_the_post_thumbnail($post->ID, 'thumbnail') . '</td>';
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
