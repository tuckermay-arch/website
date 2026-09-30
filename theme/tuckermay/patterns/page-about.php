<?php
/**
 * Title: About page
 * Slug: tuckermay/page-about
 * Categories: tuckermay-pages
 * Description: Bio with photo and links to the three main sections.
 * Block Types: core/post-content
 * Post Types: page
 * Viewport width: 1400
 *
 * @package tuckermay
 */
?>
<!-- wp:group {"className":"tm-page"} -->
<div class="wp-block-group tm-page"><!-- wp:group {"className":"tm-about"} -->
<div class="wp-block-group tm-about"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"tm-portrait"} -->
<figure class="wp-block-image size-full tm-portrait"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/tucker-about.jpg' ) ); ?>" alt="Tucker May"/></figure>
<!-- /wp:image -->

<!-- wp:group -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"tm-eyebrow"} -->
<p class="tm-eyebrow">About</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Tucker May</h1>
<!-- /wp:heading -->

<!-- wp:group {"className":"tm-bio"} -->
<div class="wp-block-group tm-bio"><!-- wp:paragraph -->
<p>Tucker May was raised in and around Springfield, Missouri in the heart of the Ozarks. He excelled in theater performance, speech and debate, and public speaking throughout his school years.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>He attended Northwestern University in Evanston, Illinois and graduated with a Bachelor of Science in Theater. At Northwestern, he was trained in playwriting and acting. He was a member of the comedic performance groups Northwestern Sketch Television, The Titanic Players, and Mee-Ow.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>Since college, he has taken writing classes at Second City in Chicago, iO in Chicago, iO West in Los Angeles, The Writer’s Workshop and with TV Writer Janae Bakken.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph -->
<p>He has written two novels, <em>Death of a Billionaire</em> and <em>The Lemon House Murders</em>, as well as multiple screenplays. His newest novel, <em>The Last Dead Guy in Hell</em> is due out in 2027.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group -->
<div class="wp-block-group"><!-- wp:group {"className":"tm-section-head"} -->
<div class="wp-block-group tm-section-head"><!-- wp:paragraph {"className":"tm-eyebrow"} -->
<p class="tm-eyebrow">Where to next</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Find your way in</h2>
<!-- /wp:heading --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-jumps"} -->
<div class="wp-block-group tm-jumps"><!-- wp:paragraph {"className":"tm-jump tm-jump--pine"} -->
<p class="tm-jump tm-jump--pine"><a href="<?php echo esc_url( home_url( '/novels/' ) ); ?>"><strong>The Novels</strong> Mysteries by Tucker May</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"tm-jump tm-jump--navy"} -->
<p class="tm-jump tm-jump--navy"><a href="<?php echo esc_url( home_url( '/writing-lessons-everywhere/' ) ); ?>"><strong>Writing Lessons Everywhere</strong> A weekly newsletter for writers</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"tm-jump tm-jump--slate"} -->
<p class="tm-jump tm-jump--slate"><a href="<?php echo esc_url( home_url( '/comedy-ghostwriting/' ) ); ?>"><strong>Comedy Ghostwriting</strong> Jokes for podcasts and YouTube channels</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
