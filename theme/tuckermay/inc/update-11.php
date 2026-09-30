<?php
/**
 * One-click "Apply update 1.1" on the settings screen.
 *
 * Replaces only the Comedy, Home, and Portfolio pages with the 1.1 designs, renames the comedy page to
 * Comedy Ghostwriting at /comedy-ghostwriting/, creates the thank-you page, and resets the header to the
 * theme's version. Every other page is left alone. Old page versions stay in each page's Revisions.
 *
 * @package tuckermay
 */

defined( 'ABSPATH' ) || exit;

/**
 * Settings-screen box.
 */
function tuckermay_render_update_11() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$report = isset( $_GET['tm_update'] ) ? get_transient( 'tuckermay_update_report' ) : false;
	$done   = get_option( 'tuckermay_update_11_applied' );
	?>
	<hr>
	<h2><?php esc_html_e( 'Update 1.1: Comedy Ghostwriting and thank-you page', 'tuckermay' ); ?></h2>
	<p><?php esc_html_e( 'One click does all of this, and nothing else:', 'tuckermay' ); ?></p>
	<ul style="list-style:disc;padding-left:20px">
		<li><?php esc_html_e( 'Comedy page: new design (packages, rotating jokes, new samples), renamed "Comedy Ghostwriting", address changed to /comedy-ghostwriting/ (the old address forwards automatically).', 'tuckermay' ); ?></li>
		<li><?php esc_html_e( 'Home page: new Comedy Ghostwriting card and linked card titles.', 'tuckermay' ); ?></li>
		<li><?php esc_html_e( 'Portfolio page: Sketch Comedy Sample Packet card and renamed Comedy ghostwriting card.', 'tuckermay' ); ?></li>
		<li><?php esc_html_e( 'Creates the Thank You page at /thank-you/ (hidden from search engines, not in the menu).', 'tuckermay' ); ?></li>
		<li><?php esc_html_e( 'Header menu: "Comedy Ghostwriting", plus Sketch Comedy under Other Writing.', 'tuckermay' ); ?></li>
	</ul>
	<p><?php esc_html_e( 'The previous version of each changed page stays in its Revisions. All other pages are untouched. Safe to click more than once.', 'tuckermay' ); ?></p>

	<?php if ( is_array( $report ) ) : ?>
		<div class="notice notice-success inline"><p><strong><?php esc_html_e( 'Update applied.', 'tuckermay' ); ?></strong></p><ul style="list-style:disc;padding-left:20px">
			<?php foreach ( $report as $line ) : ?>
				<li><?php echo esc_html( $line ); ?></li>
			<?php endforeach; ?>
		</ul></div>
	<?php elseif ( $done ) : ?>
		<p><em><?php esc_html_e( 'Already applied. Clicking again re-applies it.', 'tuckermay' ); ?></em></p>
	<?php endif; ?>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<?php wp_nonce_field( 'tuckermay_update_11' ); ?>
		<input type="hidden" name="action" value="tuckermay_update_11">
		<?php submit_button( __( 'Apply update 1.1', 'tuckermay' ), 'primary', 'submit', false ); ?>
	</form>
	<?php
}

/**
 * Replace a page's content with a pattern and give it the designed template.
 *
 * @param int    $id      Page ID.
 * @param string $pattern Pattern name.
 * @param array  $extra   Extra post fields.
 * @return bool
 */
function tuckermay_apply_pattern_to_page( $id, $pattern, $extra = array() ) {
	$content = tuckermay_pattern_content( $pattern );
	if ( ! $content ) {
		return false;
	}
	$result = wp_update_post( array_merge( array( 'ID' => $id, 'post_content' => $content ), $extra ), true );
	if ( is_wp_error( $result ) ) {
		return false;
	}
	update_post_meta( $id, '_wp_page_template', 'landing' );
	return true;
}

/**
 * Handle the button.
 */
function tuckermay_handle_update_11() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'tuckermay' ) );
	}
	check_admin_referer( 'tuckermay_update_11' );
	$report = array();

	// Comedy page: find it under either address.
	$comedy = get_page_by_path( 'comedy-ghostwriting' );
	if ( ! $comedy ) {
		$comedy = get_page_by_path( 'comedy-one-sheets' );
	}
	if ( $comedy ) {
		$ok       = tuckermay_apply_pattern_to_page( $comedy->ID, 'tuckermay/page-comedy', array( 'post_title' => 'Comedy Ghostwriting', 'post_name' => 'comedy-ghostwriting', 'post_status' => 'publish' ) );
		$report[] = $ok ? __( 'Comedy page: new design, renamed Comedy Ghostwriting, now at /comedy-ghostwriting/.', 'tuckermay' ) : __( 'Comedy page: could not be updated.', 'tuckermay' );
	} else {
		$id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Comedy Ghostwriting', 'post_name' => 'comedy-ghostwriting', 'post_content' => tuckermay_pattern_content( 'tuckermay/page-comedy' ) ), true );
		if ( ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'landing' );
		}
		$report[] = is_wp_error( $id ) ? __( 'Comedy page: could not be created.', 'tuckermay' ) : __( 'Comedy page: created at /comedy-ghostwriting/.', 'tuckermay' );
	}

	// Home page.
	$home_id = (int) get_option( 'page_on_front' );
	if ( ! $home_id ) {
		$home    = get_page_by_path( 'home' );
		$home_id = $home ? $home->ID : 0;
	}
	if ( $home_id ) {
		$report[] = tuckermay_apply_pattern_to_page( $home_id, 'tuckermay/page-home' ) ? __( 'Home page: updated.', 'tuckermay' ) : __( 'Home page: could not be updated.', 'tuckermay' );
	} else {
		$report[] = __( 'Home page: not found, skipped.', 'tuckermay' );
	}

	// Portfolio.
	$portfolio = get_page_by_path( 'portfolio' );
	if ( $portfolio ) {
		$report[] = tuckermay_apply_pattern_to_page( $portfolio->ID, 'tuckermay/page-portfolio' ) ? __( 'Portfolio page: updated.', 'tuckermay' ) : __( 'Portfolio page: could not be updated.', 'tuckermay' );
	} else {
		$report[] = __( 'Portfolio page: not found, skipped.', 'tuckermay' );
	}

	// Thank-you page.
	$thanks = get_page_by_path( 'thank-you' );
	if ( $thanks ) {
		tuckermay_apply_pattern_to_page( $thanks->ID, 'tuckermay/page-thank-you', array( 'post_status' => 'publish' ) );
		$report[] = __( 'Thank You page: updated at /thank-you/.', 'tuckermay' );
	} else {
		$id = wp_insert_post( array( 'post_type' => 'page', 'post_status' => 'publish', 'post_title' => 'Thank You', 'post_name' => 'thank-you', 'post_content' => tuckermay_pattern_content( 'tuckermay/page-thank-you' ) ), true );
		if ( ! is_wp_error( $id ) ) {
			update_post_meta( $id, '_wp_page_template', 'landing' );
			$report[] = __( 'Thank You page: created at /thank-you/.', 'tuckermay' );
		} else {
			$report[] = __( 'Thank You page: could not be created.', 'tuckermay' );
		}
	}

	// Header: drop any saved customization so the theme's updated header (new menu) shows.
	$header = get_block_template( get_stylesheet() . '//header', 'wp_template_part' );
	if ( $header && 'custom' === $header->source && ! empty( $header->wp_id ) ) {
		wp_delete_post( $header->wp_id, true );
		$report[] = __( 'Header: reset to the theme version (menu now says Comedy Ghostwriting and includes Sketch Comedy).', 'tuckermay' );
	} else {
		$report[] = __( 'Header: already using the theme version.', 'tuckermay' );
	}

	update_option( 'tuckermay_update_11_applied', time() );
	set_transient( 'tuckermay_update_report', $report, 10 * MINUTE_IN_SECONDS );
	wp_safe_redirect( add_query_arg( array( 'page' => 'tuckermay-settings', 'tm_update' => 1 ), admin_url( 'themes.php' ) ) );
	exit;
}
add_action( 'admin_post_tuckermay_update_11', 'tuckermay_handle_update_11' );
