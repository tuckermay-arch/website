<?php
/**
 * One-click page setup on the settings screen.
 *
 * Creates every page in the site design from the theme's page patterns, applies the
 * "Designed page" template, and sets the homepage and privacy page.
 *
 * @package tuckermay
 */

defined( 'ABSPATH' ) || exit;

/**
 * Pages in the site, in menu order.
 *
 * @return array slug => [ title, pattern ]
 */
function tuckermay_site_pages() {
	return array(
		'home'                       => array( __( 'Home', 'tuckermay' ), 'tuckermay/page-home' ),
		'novels'                     => array( __( 'Novels', 'tuckermay' ), 'tuckermay/page-novels' ),
		'writing-lessons-everywhere' => array( __( 'Writing Lessons Everywhere', 'tuckermay' ), 'tuckermay/page-wle' ),
		'comedy-ghostwriting'        => array( __( 'Comedy Ghostwriting', 'tuckermay' ), 'tuckermay/page-comedy' ),
		'youtube-scripts'            => array( __( 'YouTube Scripts', 'tuckermay' ), 'tuckermay/page-youtube' ),
		'screenplays'                => array( __( 'Screenplays', 'tuckermay' ), 'tuckermay/page-screenplays' ),
		'tv-shows'                   => array( __( 'TV Shows', 'tuckermay' ), 'tuckermay/page-tv' ),
		'poetry-prose'               => array( __( 'Poetry / Short Stories', 'tuckermay' ), 'tuckermay/page-poetry' ),
		'about'                      => array( __( 'About', 'tuckermay' ), 'tuckermay/page-about' ),
		'blog'                       => array( __( 'Blog', 'tuckermay' ), 'tuckermay/page-blog' ),
		'contact'                    => array( __( 'Contact', 'tuckermay' ), 'tuckermay/page-contact' ),
		'portfolio'                  => array( __( 'Portfolio', 'tuckermay' ), 'tuckermay/page-portfolio' ),
		'privacy-policy'             => array( __( 'Privacy Policy', 'tuckermay' ), 'tuckermay/page-privacy' ),
		'thank-you'                  => array( __( 'Thank You', 'tuckermay' ), 'tuckermay/page-thank-you' ),
	);
}

/**
 * Markup of a registered pattern.
 *
 * @param string $slug Pattern name.
 * @return string
 */
function tuckermay_pattern_content( $slug ) {
	$pattern = WP_Block_Patterns_Registry::get_instance()->get_registered( $slug );
	return $pattern ? $pattern['content'] : '';
}

/**
 * The page-setup box on the settings screen.
 */
function tuckermay_render_setup_pages() {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$report = isset( $_GET['tm_setup'] ) ? get_transient( 'tuckermay_setup_report' ) : false;
	?>
	<hr>
	<h2><?php esc_html_e( 'Set up the site’s pages', 'tuckermay' ); ?></h2>
	<p><?php esc_html_e( 'Creates every page in the design (Home, Novels, Writing Lessons Everywhere, Comedy Ghostwriting, YouTube Scripts, Screenplays, TV Shows, Poetry / Short Stories, About, Blog, Contact, Portfolio, Privacy Policy, Thank You), fills each one with its design, makes Home the front page, and sets the privacy page.', 'tuckermay' ); ?></p>

	<?php if ( is_array( $report ) ) : ?>
		<div class="notice notice-success inline"><p><strong><?php esc_html_e( 'Done.', 'tuckermay' ); ?></strong></p><ul style="list-style:disc;padding-left:20px">
			<?php foreach ( $report as $line ) : ?>
				<li><?php echo esc_html( $line ); ?></li>
			<?php endforeach; ?>
		</ul></div>
	<?php endif; ?>

	<table class="widefat striped" style="max-width:760px">
		<thead><tr><th><?php esc_html_e( 'Page', 'tuckermay' ); ?></th><th><?php esc_html_e( 'Address', 'tuckermay' ); ?></th><th><?php esc_html_e( 'Status', 'tuckermay' ); ?></th></tr></thead>
		<tbody>
		<?php foreach ( tuckermay_site_pages() as $slug => $page ) : ?>
			<?php $existing = get_page_by_path( $slug ); ?>
			<tr>
				<td><?php echo esc_html( $page[0] ); ?></td>
				<td><code>/<?php echo esc_html( 'home' === $slug ? '' : $slug . '/' ); ?></code></td>
				<td><?php echo $existing ? esc_html__( 'Already exists', 'tuckermay' ) : esc_html__( 'Will be created', 'tuckermay' ); ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" style="margin-top:16px">
		<?php wp_nonce_field( 'tuckermay_setup_pages' ); ?>
		<input type="hidden" name="action" value="tuckermay_setup_pages">
		<p><label><input type="checkbox" name="tm_replace" value="1"> <?php esc_html_e( 'Also replace the content of pages that already exist with the new design. Their old content stays in each page’s revision history (Page → Revisions), so nothing is lost.', 'tuckermay' ); ?></label></p>
		<?php submit_button( __( 'Set up pages', 'tuckermay' ), 'primary', 'submit', false ); ?>
	</form>
	<?php
}

/**
 * Create or update the pages.
 */
function tuckermay_handle_setup_pages() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Not allowed.', 'tuckermay' ) );
	}
	check_admin_referer( 'tuckermay_setup_pages' );
	$replace = ! empty( $_POST['tm_replace'] );
	$report  = array();
	$ids     = array();

	foreach ( tuckermay_site_pages() as $slug => $page ) {
		list( $title, $pattern ) = $page;
		$content  = tuckermay_pattern_content( $pattern );
		$existing = get_page_by_path( $slug );

		if ( $existing ) {
			$ids[ $slug ] = $existing->ID;
			$unpublished = in_array( $existing->post_status, array( 'draft', 'auto-draft', 'pending' ), true );
			if ( ( $replace || $unpublished ) && $content ) {
				wp_update_post( array( 'ID' => $existing->ID, 'post_content' => $content, 'post_status' => 'publish' ) );
				update_post_meta( $existing->ID, '_wp_page_template', 'landing' );
				/* translators: %s: page title */
				$report[] = sprintf( __( '%s: replaced with the new design (old version saved in Revisions).', 'tuckermay' ), $title );
			} else {
				/* translators: %s: page title */
				$report[] = sprintf( __( '%s: already existed, left as is.', 'tuckermay' ), $title );
			}
			continue;
		}

		$id = wp_insert_post(
			array(
				'post_type'    => 'page',
				'post_status'  => 'publish',
				'post_title'   => $title,
				'post_name'    => $slug,
				'post_content' => $content,
				'menu_order'   => count( $ids ),
			),
			true
		);
		if ( is_wp_error( $id ) ) {
			/* translators: 1: page title, 2: error */
			$report[] = sprintf( __( '%1$s: could not be created (%2$s).', 'tuckermay' ), $title, $id->get_error_message() );
			continue;
		}
		update_post_meta( $id, '_wp_page_template', 'landing' );
		$ids[ $slug ] = $id;
		/* translators: %s: page title */
		$report[] = sprintf( __( '%s: created.', 'tuckermay' ), $title );
	}

	if ( ! empty( $ids['home'] ) ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $ids['home'] );
		$report[] = __( 'Home is now the front page (Settings → Reading).', 'tuckermay' );
	}
	if ( ! empty( $ids['privacy-policy'] ) ) {
		update_option( 'wp_page_for_privacy_policy', (int) $ids['privacy-policy'] );
	}

	set_transient( 'tuckermay_setup_report', $report, 10 * MINUTE_IN_SECONDS );
	wp_safe_redirect( add_query_arg( array( 'page' => 'tuckermay-settings', 'tm_setup' => 1 ), admin_url( 'themes.php' ) ) );
	exit;
}
add_action( 'admin_post_tuckermay_setup_pages', 'tuckermay_handle_setup_pages' );
