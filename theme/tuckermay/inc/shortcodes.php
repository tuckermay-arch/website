<?php
/**
 * Shortcodes used inside the page designs.
 *
 * [tm_substack_signup]  Email box that hands off to Substack's subscribe page.
 * [tm_book_signup]      "Notify me" box for new-book news (MailerLite), then offers the newsletter.
 * [tm_substack_posts]   Latest Substack posts. count="2" layout="list" | layout="cards" count="5" more="5".
 * [tm_year]             The current year (for the footer).
 *
 * @package tuckermay
 */

defined( 'ABSPATH' ) || exit;

/**
 * [tm_substack_signup label="Subscribe free"]
 */
function tuckermay_sc_substack_signup( $atts ) {
	static $n = 0;
	$n++;
	$atts = shortcode_atts( array( 'label' => __( 'Subscribe free', 'tuckermay' ) ), $atts, 'tm_substack_signup' );
	$id   = 'tm-sub-' . $n;
	ob_start();
	?>
	<form class="tm-signup tm-signup--substack" action="<?php echo esc_url( tuckermay_substack_url() . '/subscribe' ); ?>" method="get" target="_blank">
		<label class="screen-reader-text" for="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Email address', 'tuckermay' ); ?></label>
		<input id="<?php echo esc_attr( $id ); ?>" type="email" name="email" placeholder="you@email.com" required autocomplete="email">
		<button class="tm-btn" type="submit"><?php echo esc_html( $atts['label'] ); ?></button>
	</form>
	<?php
	return ob_get_clean();
}
add_shortcode( 'tm_substack_signup', 'tuckermay_sc_substack_signup' );

/**
 * [tm_book_signup label="Notify me"]
 */
function tuckermay_sc_book_signup( $atts ) {
	static $n = 0;
	$n++;
	$atts = shortcode_atts( array( 'label' => __( 'Notify me', 'tuckermay' ) ), $atts, 'tm_book_signup' );
	$id   = 'tm-book-' . $n;
	$ml   = tuckermay_get_option( 'mailerlite_action' );
	ob_start();
	?>
	<div class="tm-book-signup">
		<form class="tm-signup tm-signup--book" data-tm-book-signup>
			<label class="screen-reader-text" for="<?php echo esc_attr( $id ); ?>"><?php esc_html_e( 'Email address', 'tuckermay' ); ?></label>
			<input id="<?php echo esc_attr( $id ); ?>" type="email" name="fields[email]" placeholder="you@email.com" required autocomplete="email">
			<button class="tm-btn" type="submit"><?php echo esc_html( $atts['label'] ); ?></button>
		</form>
		<p class="tm-signup-error" role="alert" hidden><?php esc_html_e( 'That didn’t go through. Check the address and try again.', 'tuckermay' ); ?></p>
		<div class="tm-followup" hidden>
			<p class="tm-followup-done"><?php esc_html_e( 'You’re on the list for release news.', 'tuckermay' ); ?></p>
			<p><?php esc_html_e( 'Want Writing Lessons Everywhere too? It’s my free weekly newsletter on Substack.', 'tuckermay' ); ?></p>
			<p class="tm-followup-row">
				<button class="tm-btn tm-btn--navy" type="button" data-tm-wle-yes><?php esc_html_e( 'Yes, subscribe me', 'tuckermay' ); ?></button>
				<button class="tm-btn tm-btn--ghost" type="button" data-tm-wle-no><?php esc_html_e( 'No thanks', 'tuckermay' ); ?></button>
			</p>
		</div>
		<?php if ( ! $ml && current_user_can( 'manage_options' ) ) : ?>
			<p class="tm-admin-note"><?php esc_html_e( 'Only you can see this: connect MailerLite under Appearance → Tucker May Settings so this form saves emails.', 'tuckermay' ); ?></p>
		<?php endif; ?>
	</div>
	<?php
	return ob_get_clean();
}
add_shortcode( 'tm_book_signup', 'tuckermay_sc_book_signup' );

/**
 * Cache the Substack feed for one hour instead of WordPress's default twelve.
 */
function tuckermay_feed_lifetime( $lifetime, $url ) {
	if ( false !== strpos( (string) $url, 'substack.com' ) ) {
		return HOUR_IN_SECONDS;
	}
	return $lifetime;
}
add_filter( 'wp_feed_cache_transient_lifetime', 'tuckermay_feed_lifetime', 10, 2 );

/**
 * Fetch Substack posts as simple arrays.
 *
 * @param int $max Maximum items.
 * @return array
 */
function tuckermay_substack_items( $max = 20 ) {
	include_once ABSPATH . WPINC . '/feed.php';
	$feed = fetch_feed( tuckermay_substack_url() . '/feed' );
	if ( is_wp_error( $feed ) ) {
		return array();
	}
	$items = array();
	foreach ( $feed->get_items( 0, $max ) as $item ) {
		$image     = '';
		$enclosure = $item->get_enclosure();
		if ( $enclosure && $enclosure->get_link() && false !== strpos( (string) $enclosure->get_type(), 'image' ) ) {
			$image = $enclosure->get_link();
		}
		$items[] = array(
			'title'    => wp_strip_all_tags( $item->get_title() ),
			'link'     => $item->get_permalink(),
			'date'     => $item->get_date( 'M j, Y' ),
			'subtitle' => wp_strip_all_tags( html_entity_decode( (string) $item->get_description(), ENT_QUOTES, 'UTF-8' ) ),
			'image'    => $image,
		);
	}
	return $items;
}

/**
 * [tm_substack_posts count="2" layout="list"]
 * [tm_substack_posts count="5" layout="cards" more="5"]
 */
function tuckermay_sc_substack_posts( $atts ) {
	$atts  = shortcode_atts( array( 'count' => 3, 'layout' => 'list', 'more' => 0 ), $atts, 'tm_substack_posts' );
	$count = max( 1, (int) $atts['count'] );
	$more  = max( 0, (int) $atts['more'] );
	$items = tuckermay_substack_items( $more ? 20 : $count );

	if ( ! $items ) {
		return '<p class="tm-feed-fallback"><a href="' . esc_url( tuckermay_substack_url() . '/archive' ) . '" target="_blank" rel="noopener">' . esc_html__( 'Read the latest posts on Substack →', 'tuckermay' ) . '</a></p>';
	}

	ob_start();
	if ( 'cards' === $atts['layout'] ) {
		echo '<div class="tm-post-cards" data-tm-more="' . esc_attr( $more ) . '">';
		foreach ( $items as $i => $post ) {
			$hidden = $i >= $count ? ' hidden' : '';
			echo '<a class="tm-post-card" href="' . esc_url( $post['link'] ) . '" target="_blank" rel="noopener"' . $hidden . '>'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			if ( $post['image'] ) {
				echo '<img class="tm-post-card__img" src="' . esc_url( $post['image'] ) . '" alt="" loading="lazy">';
			} else {
				echo '<span class="tm-post-card__img tm-post-card__img--empty" aria-hidden="true"></span>';
			}
			echo '<span class="tm-post-card__text"><span class="tm-post-card__title">' . esc_html( $post['title'] ) . '</span>';
			if ( $post['subtitle'] ) {
				echo '<span class="tm-post-card__sub">' . esc_html( wp_trim_words( $post['subtitle'], 30 ) ) . '</span>';
			}
			echo '</span></a>';
		}
		echo '</div>';
		if ( $more && count( $items ) > $count ) {
			echo '<p class="tm-more-row"><button class="tm-btn tm-btn--ghost" type="button" data-tm-load-more>' . esc_html__( 'Load more', 'tuckermay' ) . '</button></p>';
		}
		echo '<p class="tm-more-row tm-archive-link" hidden><a href="' . esc_url( tuckermay_substack_url() . '/archive' ) . '" target="_blank" rel="noopener">' . esc_html__( 'See every post on Substack →', 'tuckermay' ) . '</a></p>';
	} else {
		echo '<ul class="tm-post-list">';
		foreach ( array_slice( $items, 0, $count ) as $post ) {
			echo '<li><a href="' . esc_url( $post['link'] ) . '" target="_blank" rel="noopener">' . esc_html( $post['title'] ) . '</a><span>' . esc_html( $post['date'] ) . '</span></li>';
		}
		echo '</ul>';
	}
	return ob_get_clean();
}
add_shortcode( 'tm_substack_posts', 'tuckermay_sc_substack_posts' );

/**
 * [tm_year]
 */
function tuckermay_sc_year() {
	return esc_html( wp_date( 'Y' ) );
}
add_shortcode( 'tm_year', 'tuckermay_sc_year' );
