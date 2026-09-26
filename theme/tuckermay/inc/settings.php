<?php
/**
 * Theme settings screen: Appearance → Tucker May Settings.
 *
 * @package tuckermay
 */

defined( 'ABSPATH' ) || exit;

/**
 * Default option values.
 */
function tuckermay_defaults() {
	return array(
		'substack_url'      => 'https://tuckermaymysteries.substack.com',
		'mailerlite_action' => '',
		'contact_email'     => 'Tucker@TuckerMayBooks.com',
	);
}

/**
 * Read one theme option.
 *
 * @param string $key Option key.
 * @return string
 */
function tuckermay_get_option( $key ) {
	$options = wp_parse_args( (array) get_option( 'tuckermay_options', array() ), tuckermay_defaults() );
	return isset( $options[ $key ] ) ? (string) $options[ $key ] : '';
}

/**
 * Substack publication URL without a trailing slash.
 */
function tuckermay_substack_url() {
	return untrailingslashit( tuckermay_get_option( 'substack_url' ) );
}

/**
 * Pull the form action URL out of a pasted MailerLite embed code, or accept a bare URL.
 *
 * @param string $raw Pasted value.
 * @return string
 */
function tuckermay_extract_mailerlite_action( $raw ) {
	$raw = trim( (string) $raw );
	if ( preg_match( '#https://assets\.mailerlite\.com/jsonp/\d+/forms/\d+/subscribe#', $raw, $m ) ) {
		return $m[0];
	}
	if ( preg_match( '#https://[a-z0-9.-]*mailerlite\.com/[^\s"\']+#i', $raw, $m ) ) {
		return esc_url_raw( $m[0] );
	}
	return '';
}

/**
 * Sanitize the options array.
 *
 * @param array $input Raw input.
 * @return array
 */
function tuckermay_sanitize_options( $input ) {
	$input = (array) $input;
	$out   = tuckermay_defaults();

	if ( ! empty( $input['substack_url'] ) ) {
		$out['substack_url'] = esc_url_raw( untrailingslashit( trim( $input['substack_url'] ) ) );
	}
	$out['mailerlite_action'] = tuckermay_extract_mailerlite_action( isset( $input['mailerlite_action'] ) ? wp_unslash( $input['mailerlite_action'] ) : '' );
	if ( '' === $out['mailerlite_action'] && ! empty( $input['mailerlite_action'] ) ) {
		add_settings_error( 'tuckermay_options', 'mailerlite', __( 'Couldn’t find a MailerLite form address in what you pasted. Paste the full embed code from MailerLite (Forms → your form → Embed → HTML code).', 'tuckermay' ) );
	}
	if ( ! empty( $input['contact_email'] ) && is_email( trim( $input['contact_email'] ) ) ) {
		$out['contact_email'] = sanitize_email( trim( $input['contact_email'] ) );
	}
	return $out;
}

/**
 * Register the setting and the menu page.
 */
function tuckermay_admin_init() {
	register_setting(
		'tuckermay_options_group',
		'tuckermay_options',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'tuckermay_sanitize_options',
			'default'           => tuckermay_defaults(),
		)
	);
}
add_action( 'admin_init', 'tuckermay_admin_init' );

function tuckermay_admin_menu() {
	add_theme_page( __( 'Tucker May Settings', 'tuckermay' ), __( 'Tucker May Settings', 'tuckermay' ), 'manage_options', 'tuckermay-settings', 'tuckermay_render_settings' );
}
add_action( 'admin_menu', 'tuckermay_admin_menu' );

/**
 * Settings screen markup.
 */
function tuckermay_render_settings() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$ml = tuckermay_get_option( 'mailerlite_action' );
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Tucker May Settings', 'tuckermay' ); ?></h1>
		<?php settings_errors( 'tuckermay_options' ); ?>

		<form method="post" action="options.php">
			<?php settings_fields( 'tuckermay_options_group' ); ?>
			<table class="form-table" role="presentation">
				<tr>
					<th scope="row"><label for="tm-substack"><?php esc_html_e( 'Substack address', 'tuckermay' ); ?></label></th>
					<td>
						<input id="tm-substack" class="regular-text" type="url" name="tuckermay_options[substack_url]" value="<?php echo esc_attr( tuckermay_get_option( 'substack_url' ) ); ?>">
						<p class="description"><?php esc_html_e( 'Used by every “Subscribe” form and by the lists of recent posts.', 'tuckermay' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="tm-ml"><?php esc_html_e( 'MailerLite form (book release updates)', 'tuckermay' ); ?></label></th>
					<td>
						<textarea id="tm-ml" class="large-text code" rows="4" name="tuckermay_options[mailerlite_action]" placeholder="<?php esc_attr_e( 'Paste the MailerLite embed code here', 'tuckermay' ); ?>"><?php echo esc_textarea( $ml ); ?></textarea>
						<p class="description">
							<?php esc_html_e( 'In MailerLite: Forms → Embedded forms → your form → Overview → Embed form → HTML code. Paste all of it; the theme keeps only the address it needs.', 'tuckermay' ); ?>
							<br><strong><?php echo $ml ? esc_html__( 'Connected.', 'tuckermay' ) : esc_html__( 'Not connected yet: the “Notify me” forms won’t save emails until this is filled in.', 'tuckermay' ); ?></strong>
						</p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="tm-email"><?php esc_html_e( 'Send contact forms to', 'tuckermay' ); ?></label></th>
					<td>
						<input id="tm-email" class="regular-text" type="email" name="tuckermay_options[contact_email]" value="<?php echo esc_attr( tuckermay_get_option( 'contact_email' ) ); ?>">
					</td>
				</tr>
			</table>
			<?php submit_button(); ?>
		</form>

		<?php tuckermay_render_setup_pages(); ?>
	</div>
	<?php
}
