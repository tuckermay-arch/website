<?php
/**
 * Tucker May theme functions.
 *
 * @package tuckermay
 */

defined( 'ABSPATH' ) || exit;

define( 'TUCKERMAY_VERSION', '1.0.0' );

require_once get_theme_file_path( 'inc/settings.php' );
require_once get_theme_file_path( 'inc/shortcodes.php' );
require_once get_theme_file_path( 'inc/forms.php' );
require_once get_theme_file_path( 'inc/setup-pages.php' );

/**
 * Theme supports and editor styles.
 */
function tuckermay_setup() {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/theme.css' );
}
add_action( 'after_setup_theme', 'tuckermay_setup' );

/**
 * Front-end CSS and JS.
 */
function tuckermay_enqueue() {
	wp_enqueue_style( 'tuckermay', get_theme_file_uri( 'assets/css/theme.css' ), array(), TUCKERMAY_VERSION );
	wp_enqueue_script( 'tuckermay', get_theme_file_uri( 'assets/js/theme.js' ), array(), TUCKERMAY_VERSION, array( 'strategy' => 'defer', 'in_footer' => true ) );
	wp_localize_script(
		'tuckermay',
		'tuckermay',
		array(
			'substackUrl'   => tuckermay_substack_url(),
			'mailerliteUrl' => tuckermay_get_option( 'mailerlite_action' ),
		)
	);
}
add_action( 'wp_enqueue_scripts', 'tuckermay_enqueue' );

/**
 * Pattern categories shown in the block inserter.
 */
function tuckermay_pattern_categories() {
	register_block_pattern_category( 'tuckermay', array( 'label' => __( 'Tucker May: sections', 'tuckermay' ) ) );
	register_block_pattern_category( 'tuckermay-pages', array( 'label' => __( 'Tucker May: full pages', 'tuckermay' ) ) );
}
add_action( 'init', 'tuckermay_pattern_categories' );

/**
 * [tm_year] in template parts (the footer), where WordPress doesn't run shortcodes.
 */
function tuckermay_render_year( $content ) {
	return false !== strpos( $content, '[tm_year]' ) ? str_replace( '[tm_year]', esc_html( wp_date( 'Y' ) ), $content ) : $content;
}
add_filter( 'render_block_core/paragraph', 'tuckermay_render_year' );
