<?php
/**
 * Title: Blog page
 * Slug: tuckermay/page-blog
 * Categories: tuckermay-pages
 * Description: Latest Substack posts with cover images and a Load more button.
 * Block Types: core/post-content
 * Post Types: page
 * Viewport width: 1400
 *
 * @package tuckermay
 */
?>
<!-- wp:group {"className":"tm-page"} -->
<div class="wp-block-group tm-page"><!-- wp:group {"className":"tm-hero"} -->
<div class="wp-block-group tm-hero"><!-- wp:paragraph {"className":"tm-eyebrow"} -->
<p class="tm-eyebrow">Writing Lessons Everywhere</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Blog</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tm-lede"} -->
<p class="tm-lede">The latest posts from Writing Lessons Everywhere, pulled from Substack automatically.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:shortcode -->
[tm_substack_posts layout="cards" count="5" more="5"]
<!-- /wp:shortcode --></div>
<!-- /wp:group -->
