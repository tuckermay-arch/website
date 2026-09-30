<?php
/**
 * Title: Thank-you page
 * Slug: tuckermay/page-thank-you
 * Categories: tuckermay-pages
 * Description: Shown after PayPal checkout: what happens next for each package, contact email, and newsletter signup.
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
<p class="tm-eyebrow">Order received</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Thank you!</h1>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tm-lede"} -->
<p class="tm-lede">Your payment went through and your order is in. PayPal is emailing your receipt now. Here’s what happens next for the package you chose.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-ty-grid"} -->
<div class="wp-block-group tm-ty-grid"><!-- wp:group {"className":"tm-ty-card"} -->
<div class="wp-block-group tm-ty-card"><!-- wp:paragraph {"className":"tm-pk-badge"} -->
<p class="tm-pk-badge">Risk-free trial</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Single one-sheet</h3>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true,"className":"tm-steps"} -->
<ol class="wp-block-list tm-steps"><!-- wp:list-item -->
<li>I start writing from the topic you gave at checkout.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Your one-sheet arrives at your PayPal email within 5 days.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>First order? It’s risk-free: if you don’t use any of the jokes in your episode or video, email me for a full refund.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-ty-card"} -->
<div class="wp-block-group tm-ty-card"><!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Bi-Weekly Retainer</h3>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true,"className":"tm-steps"} -->
<ol class="wp-block-list tm-steps"><!-- wp:list-item -->
<li>This month’s sheets are based on the topics you listed at checkout. The first one arrives within 3 days.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Each month you’ll receive a new PayPal invoice. List that month’s topics when you pay it.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Two sheets per month, each delivered within 3 days. Cancel anytime.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-ty-card"} -->
<div class="wp-block-group tm-ty-card"><!-- wp:paragraph {"className":"tm-pk-badge"} -->
<p class="tm-pk-badge">Best deal</p>
<!-- /wp:paragraph -->

<!-- wp:heading {"level":3} -->
<h3 class="wp-block-heading">Monthly Retainer</h3>
<!-- /wp:heading -->

<!-- wp:list {"ordered":true,"className":"tm-steps"} -->
<ol class="wp-block-list tm-steps"><!-- wp:list-item -->
<li>This month’s sheets are based on the topics you listed at checkout. The first one arrives within 3 days.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Each month you’ll receive a new PayPal invoice. List that month’s topics when you pay it.</li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li>Four sheets per month, each delivered within 3 days. Cancel anytime.</li>
<!-- /wp:list-item --></ol>
<!-- /wp:list --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-panel"} -->
<div class="wp-block-group tm-panel"><!-- wp:heading -->
<h2 class="wp-block-heading">Questions about your order?</h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"tm-lede"} -->
<p class="tm-lede">Email <a href="mailto:tucker@tuckermaybooks.com">tucker@tuckermaybooks.com</a> and I’ll get back to you.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:group {"className":"tm-cross"} -->
<div class="wp-block-group tm-cross"><!-- wp:group -->
<div class="wp-block-group"><!-- wp:paragraph {"className":"tm-eyebrow"} -->
<p class="tm-eyebrow">While you wait</p>
<!-- /wp:paragraph -->

<!-- wp:heading -->
<h2 class="wp-block-heading">Writing Lessons Everywhere</h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p>My free weekly newsletter: practical writing lessons from the pop culture in the headlines.</p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button {"className":"tm-btn-blue"} -->
<div class="wp-block-button tm-btn-blue"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( tuckermay_substack_url() . '/subscribe' ); ?>" target="_blank" rel="noreferrer noopener">Subscribe free</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
