<?php

/**
 * Theme setup.
 */

namespace App;

use function Roots\asset;
use PostTypes\PostType;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ['jquery'], null, true);
    wp_enqueue_script('sage/app.js', asset('scripts/app.js')->uri(), ['sage/vendor.js'], null, true);

    wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_style('sage/app.css', asset('styles/app.css')->uri(), false, null);
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    if ($manifest = asset('scripts/manifest.asset.php')->get()) {
        wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ...array_values($manifest));
        wp_enqueue_script('sage/editor.js', asset('scripts/editor.js')->uri(), ['sage/vendor.js'], null, true);

        wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');
    }

    wp_enqueue_style('sage/editor.css', asset('styles/editor.css')->uri(), false, null);
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from the Soil plugin if activated.
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
    'clean-up',
    'disable-rest-api',
    'disable-asset-versioning',
    'disable-trackbacks',
    'google-analytics' => 'UA-XXXXX-Y',
    'js-to-footer',
    'nav-walker',
    'nice-search',
    'relative-urls'
    ]);

    /**
     * Register the navigation menus.
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Register the editor color palette.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
     */
    add_theme_support('editor-color-palette', []);

    /**
     * Register the editor color gradient presets.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets
     */
    add_theme_support('editor-gradient-presets', []);

    /**
     * Register the editor font sizes.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-font-sizes
     */
    add_theme_support('editor-font-sizes', []);

    /**
     * Register relative length units in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#support-custom-units
     */
    add_theme_support('custom-units');

    /**
     * Enable support for custom line heights in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#supporting-custom-line-heights
     */
    add_theme_support('custom-line-height');

    /**
     * Enable support for custom block spacing control in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#spacing-control
     */
    add_theme_support('custom-spacing');

    /**
     * Disable custom colors in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
     */
    add_theme_support('disable-custom-colors');

    /**
     * Disable custom color gradients in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
     */
    add_theme_support('disable-custom-gradients');

    /**
     * Disable custom font sizes in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
     */
    add_theme_support('disable-custom-font-sizes');

    /**
     * Disable the default block patterns.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable wide alignment support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
     */
    add_theme_support('align-wide');

    /**
     * Enable responsive embed support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style'
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/* Enable custom logo */

add_theme_support( 'custom-logo' );

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary'
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer'
    ] + $config);
});


/**
* Register custom post type bt jjgrainger.
*
* @return void
*/

$books = new PostType('book');

$books->register();

// //////////////////////
// // SECURE WP_ADMIN //
// //////////////////////
// // ---- 1. edit wp-config.php
// /* tells wordpress what the new directory is, and updates the cookie path.
// define( 'WP_ADMIN_DIR', 'manager' );
// define( 'ADMIN_COOKIE_PATH', '/' );
// */

// // ---- 2. Url Rewrite
// /* for APACHE
// RewriteRule ^manager/(.*) wp-admin/$1?%{QUERY_STRING} [L]
// RewriteRule ^connect$ wp-login.php
// */
// /* for NGINX
// location ~ ^/ifSubFolder/manager/(.*)$ {
// try_files $uri $uri/ /ifSubFolder/wp-admin/$1;
// }
// location ~ ^/ifSubFolder/connect {
// try_files $uri $uri/ /ifSubFolder/wp-login.php?$args;
// }
// */

// // NEXT in functions.php

// // ---- 3. redirects the user if there are trying to reach either of the secure areas.
// if (strpos($_SERVER['REQUEST_URI'], 'wp-admin') !== false || strpos($_SERVER['REQUEST_URI'], 'wp-login') !== false ||
// strpos($_SERVER['REQUEST_URI'], 'admin') !== false || strpos($_SERVER['REQUEST_URI'], 'login') !== false) {
// header("HTTP/1.1 301 Moved Permanently");
// header('Location: /ifSubFolder/'); die();
// }
// // ---- 4. replace wp-admin url’s with the proper name.
// add_filter('site_url', function ( $url, $path, $orig_scheme ) {
// $old = array( "/(wp-admin)/");
// $admin_dir = WP_ADMIN_DIR;
// $new = array($admin_dir);
// return preg_replace( $old, $new, $url, 1);
// }, 10, 3);

// // ---- 5. make sure the login page redirects to the proper page.
// add_action('login_form','redirect_wp_admin');
// function redirect_wp_admin(){
// $redirect_to = $_SERVER['REQUEST_URI'];
// if(count($_REQUEST)> 0 && array_key_exists('redirect_to', $_REQUEST)) {
// $redirect_to = $_REQUEST['redirect_to'];
// }
// }
// // --- 6. function to handle the same issues the wpadmin_filter does with naming.
// add_filter('site_url', function ( $url, $path, $orig_scheme ) {
// $old = array( "/(wp-login\.php)/");
// $new = array( "connect");
// return preg_replace( $old, $new, $url, 1);
// }, 10, 3);

// // END SECURE ADMIN/LOGIN URL