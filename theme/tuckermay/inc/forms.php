<?php
/**
 * Contact and script-request forms, sent by email. No plugin needed.
 *
 * [tm_contact_form topic="YouTube scripts"]  Name, email, "What's this about?", message.
 * [tm_script_request]                        Script, name, email, note. Each "Request script"
 *                                            button on the page fills in the script title.
 *
 * @package tuckermay
 */

defined( 'ABSPATH' ) || exit;

/**
 * Topics offered in the contact form dropdown.
 */
function tuckermay_topics() {
	return array(
		__( 'Books', 'tuckermay' ),
		__( 'Writing Lessons Everywhere', 'tuckermay' ),
		__( 'Comedy ghostwriting', 'tuckermay' ),
		__( 'YouTube scripts', 'tuckermay' ),
		__( 'Screenplays or TV scripts', 'tuckermay' ),
		__( 'Other', 'tuckermay' ),
	);
}

/**
 * Status message after a submission.
 *
 * @param string $form Form type.
 * @return string
 */
function tuckermay_form_notice( $form ) {
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$status = isset( $_GET['tm_form'], $_GET['tm_status'] ) && $form === $_GET['tm_form'] ? sanitize_key( $_GET['tm_status'] ) : '';
	if ( 'sent' === $status ) {
		return '<p class="tm-form-notice tm-form-notice--ok" role="status">' . esc_html__( 'Thanks! Your message is on its way. I’ll reply by email.', 'tuckermay' ) . '</p>';
	}
	if ( 'mailfail' === $status ) {
		/* translators: %s: email address */
		return '<p class="tm-form-notice tm-form-notice--error" role="alert">' . esc_html( sprintf( __( 'Sorry, the message couldn’t be delivered. Please email %s directly.', 'tuckermay' ), tuckermay_get_option( 'contact_email' ) ) ) . '</p>';
	}
	if ( 'error' === $status ) {
		return '<p class="tm-form-notice tm-form-notice--error" role="alert">' . esc_html__( 'That didn’t send. Check that your name, email, and message are filled in, then try again.', 'tuckermay' ) . '</p>';
	}
	return '';
}

/**
 * Hidden fields shared by both forms (spam traps and return address).
 *
 * @param string $form Form type.
 */
function tuckermay_form_hidden( $form ) {
	?>
	<input type="hidden" name="action" value="tuckermay_form">
	<input type="hidden" name="tm_form" value="<?php echo esc_attr( $form ); ?>">
	<input type="hidden" name="tm_t" value="<?php echo esc_attr( time() ); ?>">
	<input type="hidden" name="tm_back" value="<?php echo esc_url( get_permalink() ); ?>">
	<p class="tm-hp" aria-hidden="true"><label>Leave this empty <input type="text" name="tm_website" tabindex="-1" autocomplete="off"></label></p>
	<?php
}

/**
 * [tm_contact_form topic=""]
 */
function tuckermay_sc_contact_form( $atts ) {
	static $n = 0;
	$n++;
	$atts = shortcode_atts( array( 'topic' => '', 'button' => __( 'Send message', 'tuckermay' ) ), $atts, 'tm_contact_form' );
	$p    = 'tm-c' . $n . '-';
	ob_start();
	?>
	<div class="tm-form-wrap" id="contact-form">
		<?php echo tuckermay_form_notice( 'contact' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<form class="tm-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<div class="tm-form-row">
				<label for="<?php echo esc_attr( $p ); ?>name"><?php esc_html_e( 'Name', 'tuckermay' ); ?><input id="<?php echo esc_attr( $p ); ?>name" type="text" name="tm_name" required autocomplete="name"></label>
				<label for="<?php echo esc_attr( $p ); ?>email"><?php esc_html_e( 'Email', 'tuckermay' ); ?><input id="<?php echo esc_attr( $p ); ?>email" type="email" name="tm_email" required autocomplete="email"></label>
			</div>
			<label for="<?php echo esc_attr( $p ); ?>topic"><?php esc_html_e( 'What’s this about?', 'tuckermay' ); ?>
				<select id="<?php echo esc_attr( $p ); ?>topic" name="tm_topic">
					<option value=""><?php esc_html_e( 'Choose one', 'tuckermay' ); ?></option>
					<?php foreach ( tuckermay_topics() as $topic ) : ?>
						<option<?php selected( strtolower( $atts['topic'] ), strtolower( $topic ) ); ?>><?php echo esc_html( $topic ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>
			<label for="<?php echo esc_attr( $p ); ?>msg"><?php esc_html_e( 'Message', 'tuckermay' ); ?><textarea id="<?php echo esc_attr( $p ); ?>msg" name="tm_message" rows="5" required></textarea></label>
			<?php tuckermay_form_hidden( 'contact' ); ?>
			<p><button class="tm-btn" type="submit"><?php echo esc_html( $atts['button'] ); ?></button></p>
		</form>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'tm_contact_form', 'tuckermay_sc_contact_form' );

/**
 * [tm_script_request]
 */
function tuckermay_sc_script_request() {
	ob_start();
	?>
	<div class="tm-form-wrap" id="request-form">
		<?php echo tuckermay_form_notice( 'request' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
		<form class="tm-form" method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<label for="tm-r-script"><?php esc_html_e( 'Script', 'tuckermay' ); ?><input id="tm-r-script" type="text" name="tm_script" required placeholder="<?php esc_attr_e( 'Click “Request script” on any title above', 'tuckermay' ); ?>" data-tm-script-field></label>
			<div class="tm-form-row">
				<label for="tm-r-name"><?php esc_html_e( 'Name', 'tuckermay' ); ?><input id="tm-r-name" type="text" name="tm_name" required autocomplete="name"></label>
				<label for="tm-r-email"><?php esc_html_e( 'Email', 'tuckermay' ); ?><input id="tm-r-email" type="email" name="tm_email" required autocomplete="email"></label>
			</div>
			<label for="tm-r-msg"><?php esc_html_e( 'Anything I should know? (optional)', 'tuckermay' ); ?><textarea id="tm-r-msg" name="tm_message" rows="3"></textarea></label>
			<?php tuckermay_form_hidden( 'request' ); ?>
			<p><button class="tm-btn" type="submit"><?php esc_html_e( 'Send request', 'tuckermay' ); ?></button></p>
		</form>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'tm_script_request', 'tuckermay_sc_script_request' );

/**
 * Handle both forms and email the result.
 */
function tuckermay_handle_form() {
	// Public forms on cacheable pages: spam is handled with a honeypot, a minimum fill time, and a per-IP limit instead of a nonce.
	// phpcs:disable WordPress.Security.NonceVerification.Missing
	$form = isset( $_POST['tm_form'] ) && 'request' === $_POST['tm_form'] ? 'request' : 'contact';
	$back = isset( $_POST['tm_back'] ) ? esc_url_raw( wp_unslash( $_POST['tm_back'] ) ) : home_url( '/' );
	$back = wp_validate_redirect( $back, home_url( '/' ) );
	$go   = function ( $status ) use ( $back, $form ) {
		$anchor = 'request' === $form ? '#request-form' : '#contact-form';
		wp_safe_redirect( add_query_arg( array( 'tm_form' => $form, 'tm_status' => $status ), $back ) . $anchor );
		exit;
	};

	$honeypot = isset( $_POST['tm_website'] ) ? trim( wp_unslash( $_POST['tm_website'] ) ) : '';
	$started  = isset( $_POST['tm_t'] ) ? (int) $_POST['tm_t'] : 0;
	if ( '' !== $honeypot || ( time() - $started ) < 3 ) {
		$go( 'sent' ); // Pretend success to bots.
	}

	$ip  = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : '';
	$key = 'tm_form_' . md5( $ip );
	$hit = (int) get_transient( $key );
	if ( $hit >= 5 ) {
		$go( 'error' );
	}
	set_transient( $key, $hit + 1, 10 * MINUTE_IN_SECONDS );

	$name    = isset( $_POST['tm_name'] ) ? sanitize_text_field( wp_unslash( $_POST['tm_name'] ) ) : '';
	$email   = isset( $_POST['tm_email'] ) ? sanitize_email( wp_unslash( $_POST['tm_email'] ) ) : '';
	$message = isset( $_POST['tm_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['tm_message'] ) ) : '';
	$topic   = isset( $_POST['tm_topic'] ) ? sanitize_text_field( wp_unslash( $_POST['tm_topic'] ) ) : '';
	$script  = isset( $_POST['tm_script'] ) ? sanitize_text_field( wp_unslash( $_POST['tm_script'] ) ) : '';
	// phpcs:enable

	if ( '' === $name || ! is_email( $email ) || ( 'contact' === $form && '' === $message ) || ( 'request' === $form && '' === $script ) ) {
		$go( 'error' );
	}

	if ( 'request' === $form ) {
		/* translators: %s: script title */
		$subject = sprintf( __( 'Script request: %s', 'tuckermay' ), $script );
		$body    = "Script: {$script}\nName: {$name}\nEmail: {$email}\n\n{$message}";
	} else {
		/* translators: %s: topic */
		$subject = sprintf( __( 'Website message: %s', 'tuckermay' ), $topic ? $topic : __( 'General', 'tuckermay' ) );
		$body    = "Name: {$name}\nEmail: {$email}\nTopic: {$topic}\n\n{$message}";
	}
	$body .= "\n\n—\nSent from " . $back;

	$sent = wp_mail( tuckermay_get_option( 'contact_email' ), $subject, $body, array( 'Reply-To: ' . $name . ' <' . $email . '>' ) );
	$go( $sent ? 'sent' : 'mailfail' );
}
add_action( 'admin_post_nopriv_tuckermay_form', 'tuckermay_handle_form' );
add_action( 'admin_post_tuckermay_form', 'tuckermay_handle_form' );
