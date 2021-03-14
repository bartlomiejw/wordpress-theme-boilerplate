<?php

/**
 * Theme filters.
 */

namespace App;

/**
 * Add "… Continued" to the excerpt.
 *
 * @return string
 */
add_filter('excerpt_more', function () {
    return sprintf(' &hellip; <a href="%s">%s</a>', get_permalink(), __('Continued', 'sage'));
});

/**
* Set comment count to always be zero.
*
* @link https://developer.wordpress.org/reference/hooks/wp_count_comments/
*/
add_filter(
'wp_count_comments',
function ( $count ) {
return (object) array(
'approved' => 0,
'spam' => 0,
'trash' => 0,
'post-trashed' => 0,
'total_comments' => 0,
'all' => 0,
'moderated' => 0,
);
}
);


/**
* Remove default fields in comment form
*
* @link https://developer.wordpress.org/reference/hooks/comment_form_default_fields/
*/
add_filter(
'comment_form_default_fields',
function ( $fields ) {
unset( $fields['author'] );
unset( $fields['email'] );
unset( $fields['url'] );

return $fields;
}
);

/**
* Remove emoji support
*
* @link https://wordpress.org/support/article/using-smilies/
*/

add_action(
'init',
function () {
// Front-end
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'wp_print_styles', 'print_emoji_styles' );

// Admin
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Feeds
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

// Embeds
remove_filter( 'embed_head', 'print_emoji_detection_script' );

// Emails
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );

// Disable from TinyMCE editor. Disabled in block editor by default
add_filter(
'tiny_mce_plugins',
function ( $plugins ) {
if ( is_array( $plugins ) ) {
$plugins = array_diff( $plugins, array( 'wpemoji' ) );
}

return $plugins;
}
);

/**
* Finally, disable it from the database also, to prevent characters from converting
* There used to be a setting under Writings to do this
* Not ideal to get & update it here - but it works :/
*/
if ( (int) get_option( 'use_smilies' ) === 1 ) {
update_option( 'use_smilies', 0 );
}
}
);

/**
* Custom Search Form
*/

// add_filter('get_search_form', function () {
// $form = '';
// echo template('partials.searchform');
// return $form;
// });


add_filter( 'nav_menu_link_attributes', function ( $atts, $item, $args ) {
if (property_exists($args, 'link_class')) {
$atts['class'] = $args->link_class;
}
return $atts;
}, 1, 3 );


add_filter('nav_menu_css_class', function ($classes, $item, $args) {
if (property_exists($args, 'list_item_class')) {
$classes[] = $args->list_item_class;
}
return $classes;
}, 1, 3);