<?php
/**
 * Template Name: Projects Archive
 */

get_header();

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array(
    'post_type'      => 'projects',
    'posts_per_page' => 6,
    'paged'          => $paged,
);

$query = new WP_Query($args);

if ($query->have_posts()) :
    while ($query->have_posts()) : $query->the_post();
        // Your project content here
        ?>
        <article <?php post_class(); ?>>
            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </article>
        <?php
    endwhile;

    // Pagination
    echo '<div class="pagination">';
    echo paginate_links(array(
        'total'    => $query->max_num_pages,
        'current'  => max(1, get_query_var('paged')),
        'prev_text' => __('&laquo; Previous', 'text_domain'),
        'next_text' => __('Next &raquo;', 'text_domain'),
    ));
    echo '</div>';

else :
    // No posts found
    echo '<p>No projects found.</p>';

endif;

// Restore original post data
wp_reset_postdata();
echo do_shortcode( '[display_coffee]' );
echo do_shortcode( '[kanye_quotes]' );

get_footer();
?>
<script>
    // Make Ajax request to get projects
jQuery(document).ready(function($) {
    var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';

    $.ajax({
        url: ajaxurl,
        type: 'POST',
        data: {
            action: 'get_architecture_projects',
        },
        success: function(response) {
            if (response.success) {
                // Handle the returned data
                var projects = response.data;
                console.log(projects);
            } else {
                console.error('Ajax request failed.');
            }
        },
        error: function(error) {
            console.error('Ajax request failed:', error);
        }
    });
});

</script>

