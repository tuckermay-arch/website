<?php
/**
 * Title: Story or poem entry (published elsewhere)
 * Slug: tuckermay/entry-story-external
 * Categories: tuckermay
 * Description: Label, title, where it was published, and a link to read it there.
 * Viewport width: 1400
 *
 * @package tuckermay
 */
?>
<!-- wp:group {"className":"tm-entry tm-panel"} -->
<div class="wp-block-group tm-entry tm-panel"><!-- wp:group {"className":"tm-entry-body"} -->
<div class="wp-block-group tm-entry-body"><!-- wp:paragraph {"className":"tm-chip"} -->
<p class="tm-chip">Short story</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3,"className":"tm-entry-title"} -->
<h3 class="wp-block-heading tm-entry-title">[Title]</h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tm-entry-summary"} -->
<p class="tm-entry-summary">Published in [Publication]</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"is-style-outline"} -->
<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="#" target="_blank" rel="noreferrer noopener">Read at [Publication] ↗</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
