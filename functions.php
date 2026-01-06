<?php

// 1. CARGA DE ASSETS
function theme_enqueue_assets() {
    $css_base    = get_template_directory_uri() . '/assets/css/base/';
    $css_layout  = get_template_directory_uri() . '/assets/css/layout/';
    $css_modules = get_template_directory_uri() . '/assets/css/modules/';
    $css_pages   = get_template_directory_uri() . '/assets/css/pages/';

    // Base
    wp_enqueue_style('reset',   $css_base . 'reset.css');
    wp_enqueue_style('globals', $css_base . 'globals.css');

    // Layout
    wp_enqueue_style('grid',    $css_layout . 'grid.css');
    wp_enqueue_style('header',  $css_layout . 'header.css');
    wp_enqueue_style('navbar',  $css_layout . 'navbar.css');
    wp_enqueue_style('sidebar', $css_layout . 'sidebar.css');
    wp_enqueue_style('footer',  $css_layout . 'footer.css');

    // Modules
    wp_enqueue_style('sticky',     $css_modules . 'sticky.css');
    wp_enqueue_style('posts-list', $css_modules . 'posts-list.css');
    wp_enqueue_style('pagination', $css_modules . 'pagination.css');
    wp_enqueue_style('button-top', $css_modules . 'button-top.css');
    wp_enqueue_style('related',    $css_modules . 'related.css');

    // Responsive
    wp_enqueue_style('responsive', $css_base . 'responsive.css');

    // Pages
    wp_enqueue_style('single', $css_pages . 'single.css');
    wp_enqueue_style('page',   $css_pages . 'page.css');
    if (is_404()) {
        wp_enqueue_style('error-404', $css_pages . '404.css');
    }
    if (is_archive() || is_search()) {
        wp_enqueue_style('archive',   $css_pages . 'archive.css');
    }

    // Main Style
    wp_enqueue_style('main', get_stylesheet_uri());

    // Scripts
    wp_enqueue_script(
        "theme-js",
        get_template_directory_uri() . "/assets/js/script.js",
        array("jquery"),
        "1.0",
        true
    );
}
add_action('wp_enqueue_scripts', 'theme_enqueue_assets');


// 2. SOPORTE DEL TEMA
add_theme_support("custom-logo");
add_theme_support("menus");
add_theme_support('title-tag');
add_theme_support('post-thumbnails');

register_nav_menus([
    "main_menu" => "Menú Principal"
]);


// 3. ARCHIVOS INCLUDE
require get_template_directory() . '/includes/customizer.php';


// 4. REGISTRO DE SIDEBARS
function theme_register_sidebars() {
    register_sidebar([
        'name' => 'Sidebar Principal',
        'id' => 'main_sidebar',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ]);

    register_sidebar([
        'name'          => 'Barra Superior (Header)',
        'id'            => 'top_header_widget',
        'description'   => 'Widget al centro de la barra roja superior.',
        'before_widget' => '<div id="%1$s" class="top-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<span class="screen-reader-text">',
        'after_title'   => '</span>',
    ]);

    register_sidebar([
        'name' => 'Footer 1',
        'id' => 'footer_1',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ]);

    register_sidebar([
        'name' => 'Footer 2',
        'id' => 'footer_2',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ]);

    register_sidebar([
        'name' => 'Footer 3',
        'id' => 'footer_3',
        'before_widget' => '<div class="widget-item">',
        'after_widget' => '</div>',
        'before_title' => '<h4>',
        'after_title' => '</h4>',
    ]);
}
add_action('widgets_init', 'theme_register_sidebars');


// 5. METABOXES Y HOOKS
function theme_featured_post_metabox() {
    add_meta_box('featured_metabox', 'Post Destacado', 'theme_featured_post_callback', 'post', 'side');
}
add_action('add_meta_boxes', 'theme_featured_post_metabox');

function theme_featured_post_callback($post) {
    wp_nonce_field('theme_featured_action', 'featured_nonce');
    $value = get_post_meta($post->ID, '_is_featured', true);
    ?>
    <label>
        <input type="checkbox" name="is_featured" value="1" <?php checked($value, '1'); ?>>
        Marcar como destacado
    </label>
    <?php
}

function theme_save_featured_post($post_id) {
    if (!isset($_POST['featured_nonce']) || !wp_verify_nonce($_POST['featured_nonce'], 'theme_featured_action')) return;
    if (isset($_POST['is_featured'])) {
        update_post_meta($post_id, '_is_featured', '1');
    } else {
        delete_post_meta($post_id, '_is_featured');
    }
}
add_action('save_post', 'theme_save_featured_post');

function theme_modify_home_query($query) {
    if (!is_admin() && $query->is_main_query() && (is_home() || is_front_page())) {
        $cantidad = get_theme_mod('home_posts_per_page', 10);
        $query->set('posts_per_page', absint($cantidad));
    }
}
add_action('pre_get_posts', 'theme_modify_home_query');