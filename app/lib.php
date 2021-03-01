<?php

/**
 * ACF Options page.
 *
 */

// if( function_exists('acf_add_options_page') ) {

// acf_add_options_page(array(
// 'page_title' => 'Ustawienia motywu',
// 'menu_title' => 'Ustawienia motywu',
// 'menu_slug' => 'theme-general-settings',
// 'capability' => 'edit_posts',
// 'redirect' => false
// ));

// acf_add_options_sub_page(array(
// 'page_title' => 'Theme Header Settings',
// 'menu_title' => 'Header',
// 'parent_slug' => 'theme-general-settings',
// ));

// acf_add_options_sub_page(array(
// 'page_title' => 'Theme Footer Settings',
// 'menu_title' => 'Footer',
// 'parent_slug' => 'theme-general-settings',
// ));

// }


/**
* Wordpress Custom Pagination.
*
*/

function webness_pagination( \WP_Query $wp_query = null, $echo = true, $params = [] ) {
if ( null === $wp_query ) {
global $wp_query;
}

$add_args = [];

//add query (GET) parameters to generated page URLs
/*if (isset($_GET[ 'sort' ])) {
$add_args[ 'sort' ] = (string)$_GET[ 'sort' ];
}*/

$pages = paginate_links( array_merge( [
'base' => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
'format' => '/page/%#%',
'current' => max( 1, get_query_var( 'page_val' ) ),
'total' => $wp_query->max_num_pages,
'type' => 'array',
'show_all' => true,
'end_size' => 3,
'mid_size' => 1,
'prev_next' => true,
'prev_text' => 'Poprzedni',
'next_text' => 'Następny',
'add_args' => $add_args,
'add_fragment' => ''
], $params )
);

if ( is_array( $pages ) ) {
// $current_page = (get_query_var('page_val') ? get_query_var('page_val') : 1);

$pagination = '<div class="pagination-wrap">
    <ul class="pagination">
        <li class="page-item prev-posts"></li><span>';

            foreach ( $pages as $page ) {
            $pagination .= '<li class="page-item' . (strpos($page, 'current') !== false ? ' active' : '') . '"> ' .
                str_replace('page-numbers', 'page-link', $page) . '</li>';
            }

            $pagination .= '</span>
        <li class="page-item next-posts"></li>
    </ul>
</div>';

return $pagination;
}

return null;
}

/**
* Comments turn off functions.
*
*/

add_action('admin_init', function () {
global $pagenow;

// Redirect any user trying to access comments page
if ($pagenow === 'edit-comments.php') {
wp_redirect(admin_url());
exit;
}

// Remove comments metabox from dashboard
remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

// Disable support for comments and trackbacks in post types
foreach (get_post_types() as $post_type) {
if (post_type_supports($post_type, 'comments')) {
remove_post_type_support($post_type, 'comments');
remove_post_type_support($post_type, 'trackbacks');
}
}
});

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page in menu
add_action('admin_menu', function () {
remove_menu_page('edit-comments.php');
});

// Remove comments links from admin bar
add_action('init', function () {
if (is_admin_bar_showing()) {
remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
}
});

/**
* Disable the REST API
*/
add_action(
'init',
function () {
add_filter( 'rest_jsonp_enabled', '__return_false' );

remove_action( 'xmlrpc_rsd_apis', 'rest_output_rsd' );
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
remove_action( 'template_redirect', 'rest_output_link_header', 11 );
}
);

/**
* Custom Image Size
*/

// add_action( 'after_setup_theme', function() {
// add_image_size( 'homepage-sticky-thumb', 940, 537, true );
// add_image_size( 'homepage-sidebar-thumb', 160, 160, true );
// add_image_size( 'homepage-swiper-thumb', 256, 160, true );
// add_image_size( 'article-archive-thumb', 700, 363, true );
// });


/**
* Custom single template by category
*/

// add_filter( "single_template", function($single_template) {
// global $post;

// if ( in_category( 'wydarzenia' )) {
// $single_template = get_stylesheet_directory() . '/views/single-wydarzenia.blade.php';
// }
// return $single_template;
// } ) ;

// add_filter( "single_template", function($single_template) {
// global $post;

// if ( in_category( 'minione-wydarzenia' )) {
// $single_template = get_stylesheet_directory() . '/views/single-minione-wydarzenia.blade.php';
// }
// return $single_template;
// } ) ;