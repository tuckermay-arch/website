<?php
/**
 * Title: Home page
 * Slug: tuckermay/page-home
 * Categories: tuckermay-pages
 * Description: Three cards: Books, Writing Lessons Everywhere, Comedy One-Sheets.
 * Block Types: core/post-content
 * Post Types: page
 * Viewport width: 1400
 *
 * @package tuckermay
 */
?>
<!-- wp:group {"className":"tm-home"} -->
<div class="wp-block-group tm-home"><!-- wp:columns {"className":"tm-cards"} -->
<div class="wp-block-columns tm-cards"><!-- wp:column {"className":"tm-card tm-card--books"} -->
<div class="wp-block-column tm-card tm-card--books"><!-- wp:group {"className":"tm-card-head"} -->
<div class="wp-block-group tm-card-head"><!-- wp:paragraph {"className":"tm-kicker"} -->
<p class="tm-kicker">Mystery novels</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"className":"screen-reader-text"} -->
<h2 class="wp-block-heading screen-reader-text">Books</h2>
<!-- /wp:heading -->

<!-- wp:group {"className":"tm-covers"} -->
<div class="wp-block-group tm-covers"><!-- wp:image {"sizeSlug":"full","linkDestination":"custom"} -->
<figure class="wp-block-image size-full"><a href="https://a.co/d/0a47KAUl" target="_blank" rel="noreferrer noopener"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/cover-death-of-a-billionaire.jpg' ) ); ?>" alt="Death of a Billionaire by Tucker May"/></a></figure>
<!-- /wp:image -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"custom"} -->
<figure class="wp-block-image size-full"><a href="https://a.co/d/05ZV8bDo" target="_blank" rel="noreferrer noopener"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/cover-the-lemon-house-murders.jpg' ) ); ?>" alt="The Lemon House Murders by Tucker May"/></a></figure>
<!-- /wp:image --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-card-body"} -->
<div class="wp-block-group tm-card-body"><!-- wp:columns {"className":"tm-shelf"} -->
<div class="wp-block-columns tm-shelf"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:list {"className":"tm-formats"} -->
<ul class="wp-block-list tm-formats"><!-- wp:list-item -->
<li>Hardcover</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Paperback</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Kindle</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Audiobook</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="https://a.co/d/0a47KAUl" target="_blank" rel="noreferrer noopener">Buy on Amazon</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:list {"className":"tm-formats"} -->
<ul class="wp-block-list tm-formats"><!-- wp:list-item -->
<li>Hardcover</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Paperback</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Kindle</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="https://a.co/d/05ZV8bDo" target="_blank" rel="noreferrer noopener">Buy on Amazon</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:group {"className":"tm-summaries"} -->
<div class="wp-block-group tm-summaries"><!-- wp:paragraph {"className":"tm-summary-hint"} -->
<p class="tm-summary-hint">Hover over a cover to read what the book is about.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"tm-summary"} -->
<div class="wp-block-group tm-summary"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Death of a Billionaire</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>The richest man in the world is dead. Alan Benning is the main suspect. Can he save himself and his family by finding the real killer?</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-summary"} -->
<div class="wp-block-group tm-summary"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">The Lemon House Murders</h3>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>A killer stalks the halls of Lemon House, a low-rent live-in drug rehabilitation center. Two residents must risk life and limb to prove their main suspect’s guilt while also navigating the stormy waves of early sobriety.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-soon"} -->
<div class="wp-block-group tm-soon"><!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"tm-soon-cover"} -->
<figure class="wp-block-image size-full tm-soon-cover"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/cover-the-last-dead-guy-in-hell.jpg' ) ); ?>" alt="The Last Dead Guy in Hell by Tucker May"/></figure>
<!-- /wp:image -->

<!-- wp:group {"className":"tm-soon-text"} -->
<div class="wp-block-group tm-soon-text"><!-- wp:paragraph {"className":"tm-eyebrow"} -->
<p class="tm-eyebrow">Coming soon</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">The Last Dead Guy in Hell</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tm-note"} -->
<p class="tm-note">Be the first to hear the release date.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[tm_book_signup]
<!-- /wp:shortcode --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"tm-card-foot"} -->
<p class="tm-card-foot"><a href="<?php echo esc_url( home_url( '/novels/' ) ); ?>">All books and reviews</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"tm-card tm-card--wle"} -->
<div class="wp-block-column tm-card tm-card--wle"><!-- wp:group {"className":"tm-card-head tm-wle-head"} -->
<div class="wp-block-group tm-card-head tm-wle-head"><!-- wp:paragraph {"className":"tm-kicker"} -->
<p class="tm-kicker">Weekly newsletter on Substack</p>
<!-- /wp:paragraph -->

<!-- wp:image {"sizeSlug":"full","linkDestination":"none","className":"tm-wle-wordmark"} -->
<figure class="wp-block-image size-full tm-wle-wordmark"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/wle-wordmark.jpg' ) ); ?>" alt="Writing Lessons Everywhere: Source, Mechanism, Tool"/></figure>
<!-- /wp:image -->

<!-- wp:paragraph {"className":"tm-tag"} -->
<p class="tm-tag">Writing lessons from the pop culture in the headlines.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-card-body"} -->
<div class="wp-block-group tm-card-body"><!-- wp:paragraph -->
<p>Join a community of writers working through their drafts together. Every post breaks down a movie, show, or book and comes with a worksheet for your own draft.</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[tm_substack_signup]
<!-- /wp:shortcode -->

<!-- wp:paragraph {"className":"tm-pitch"} -->
<p class="tm-pitch">If you need to refine your draft but can’t drop thousands of dollars on a book coach or narrative consultant, then Writing Lessons Everywhere is exactly what you need.</p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"tm-pitch"} -->
<p class="tm-pitch">Become a paid subscriber to access every WLE worksheet in the Under the Hood Toolkit. <a href="https://writinglessonseverywhere.netlify.app/" target="_blank" rel="noreferrer noopener">See the whole database here →</a></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"tm-label"} -->
<p class="tm-label">Latest posts</p>
<!-- /wp:paragraph -->

<!-- wp:shortcode -->
[tm_substack_posts count="2"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"tm-card-foot"} -->
<p class="tm-card-foot"><a href="<?php echo esc_url( home_url( '/writing-lessons-everywhere/' ) ); ?>">About the newsletter</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column -->

<!-- wp:column {"className":"tm-card tm-card--comedy"} -->
<div class="wp-block-column tm-card tm-card--comedy"><!-- wp:group {"className":"tm-card-head"} -->
<div class="wp-block-group tm-card-head"><!-- wp:paragraph {"className":"tm-kicker"} -->
<p class="tm-kicker">For movie and TV podcasts</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Comedy One-Sheets</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tm-tag"} -->
<p class="tm-tag">Custom jokes written for the show your next episode covers.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-card-body"} -->
<div class="wp-block-group tm-card-body"><!-- wp:paragraph {"className":"tm-creds"} -->
<p class="tm-creds">Alum of Northwestern’s Mee-Ow sketch show. Has written for comedy teams at The Second City, iO, and iO West.</p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"tm-offer tm-offer--dark"} -->
<div class="wp-block-group tm-offer tm-offer--dark"><!-- wp:group {"className":"tm-offer-head"} -->
<div class="wp-block-group tm-offer-head"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Custom one-sheet</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tm-price"} -->
<p class="tm-price">$250</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:list {"className":"tm-checks"} -->
<ul class="wp-block-list tm-checks"><!-- wp:list-item -->
<li>10 late-night-style one- and two-liner jokes</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>5 intros, transitions, and ad throws</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Delivered within 5 days</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>You own all rights. Credit optional.</li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"tm-btn-light"} -->
<div class="wp-block-button tm-btn-light"><a class="wp-block-button__link wp-element-button" href="https://www.paypal.com/ncp/payment/ZWBQS9N9BLE6G" target="_blank" rel="noreferrer noopener">Buy now</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"tm-note"} -->
<p class="tm-note">Tell me which movie or TV show your episode covers at checkout. Jokes on other topics work too.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"tm-card-foot"} -->
<p class="tm-card-foot"><a href="<?php echo esc_url( home_url( '/comedy-one-sheets/' ) ); ?>">Examples and FAQ</a></p>
<!-- /wp:paragraph --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></div>
<!-- /wp:group -->
