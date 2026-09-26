<?php
/**
 * Title: Site header
 * Slug: tuckermay/header
 * Categories: tuckermay
 * Block Types: core/template-part/header
 * Inserter: no
 * Viewport width: 1400
 *
 * @package tuckermay
 */
?>
<!-- wp:group {"className":"tm-header-inner"} -->
<div class="wp-block-group tm-header-inner"><!-- wp:group {"className":"tm-brand","layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group tm-brand"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom","className":"tm-logo"} -->
<figure class="wp-block-image size-full tm-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/tm-mark.png' ) ); ?>" alt="Tucker May Books"/></a></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"tm-photo"} -->
<figure class="wp-block-image size-full tm-photo"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/tucker-header.jpg' ) ); ?>" alt="Tucker May"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"tm-id"} -->
<div class="wp-block-group tm-id"><!-- wp:paragraph {"className":"tm-name"} -->
<p class="tm-name"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">Tucker May</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"tm-sub"} -->
<p class="tm-sub">Novels · Comedy Writing · A Community for Writers</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:navigation {"overlayMenu":"mobile","className":"tm-nav","layout":{"type":"flex","flexWrap":"wrap"}} -->
<!-- wp:navigation-link {"label":"Books","url":"<?php echo esc_url( home_url( '/novels/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Writing Lessons Everywhere","url":"<?php echo esc_url( home_url( '/writing-lessons-everywhere/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Comedy One-Sheets","url":"<?php echo esc_url( home_url( '/comedy-one-sheets/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"YouTube Scripts","url":"<?php echo esc_url( home_url( '/youtube-scripts/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-submenu {"label":"Other Writing","url":"<?php echo esc_url( home_url( '/portfolio/' ) ); ?>","kind":"custom"} -->
<!-- wp:navigation-link {"label":"Screenplays","url":"<?php echo esc_url( home_url( '/screenplays/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"TV Shows","url":"<?php echo esc_url( home_url( '/tv-shows/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Poetry / Short Stories","url":"<?php echo esc_url( home_url( '/poetry-prose/' ) ); ?>","kind":"custom"} /-->
<!-- /wp:navigation-submenu -->
<!-- wp:navigation-link {"label":"Blog","url":"<?php echo esc_url( home_url( '/blog/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"About","url":"<?php echo esc_url( home_url( '/about/' ) ); ?>","kind":"custom"} /-->
<!-- wp:navigation-link {"label":"Contact","url":"<?php echo esc_url( home_url( '/contact/' ) ); ?>","kind":"custom"} /-->
<!-- /wp:navigation --></div>
<!-- /wp:group -->
