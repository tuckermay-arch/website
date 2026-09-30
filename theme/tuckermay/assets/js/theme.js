/* Tucker May theme: small front-end behaviors. No dependencies. */
( function () {
	'use strict';

	var cfg = window.tuckermay || {};

	/* Hover a book cover to show its summary.
	   Covers live in .tm-covers; summaries are .tm-summary blocks inside .tm-summaries, in the same order. */
	document.querySelectorAll( '.tm-card--books, .tm-books-hover' ).forEach( function ( scope ) {
		var covers = scope.querySelectorAll( '.tm-covers .wp-block-image' );
		var box = scope.querySelector( '.tm-summaries' );
		if ( ! covers.length || ! box ) {
			return;
		}
		var summaries = box.querySelectorAll( '.tm-summary' );
		function show( i ) {
			box.classList.add( 'is-showing' );
			summaries.forEach( function ( s, j ) {
				s.classList.toggle( 'is-active', i === j );
			} );
			covers.forEach( function ( c, j ) {
				c.classList.toggle( 'is-active', i === j );
			} );
		}
		function hide() {
			box.classList.remove( 'is-showing' );
			summaries.forEach( function ( s ) {
				s.classList.remove( 'is-active' );
			} );
			covers.forEach( function ( c ) {
				c.classList.remove( 'is-active' );
			} );
		}
		covers.forEach( function ( cover, i ) {
			var target = cover.querySelector( 'a' ) || cover;
			cover.addEventListener( 'mouseenter', function () {
				show( i );
			} );
			cover.addEventListener( 'mouseleave', hide );
			target.addEventListener( 'focus', function () {
				show( i );
			} );
			target.addEventListener( 'blur', hide );
		} );
	} );

	/* "Request script" buttons fill in the shared request form. */
	document.querySelectorAll( '.tm-request-btn a, a.tm-request-btn' ).forEach( function ( btn ) {
		btn.addEventListener( 'click', function ( e ) {
			var field = document.querySelector( '[data-tm-script-field]' );
			if ( ! field ) {
				return;
			}
			e.preventDefault();
			var entry = btn.closest( '.tm-entry' );
			var title = entry ? entry.querySelector( '.tm-entry-title' ) : null;
			if ( title ) {
				field.value = title.textContent.trim();
			}
			var form = document.getElementById( 'request-form' );
			if ( form ) {
				form.scrollIntoView( { behavior: 'smooth', block: 'start' } );
			}
			setTimeout( function () {
				field.focus( { preventScroll: true } );
			}, 400 );
		} );
	} );

	/* Book release signup: send to MailerLite, then offer the newsletter. */
	document.querySelectorAll( '.tm-book-signup' ).forEach( function ( wrap ) {
		var form = wrap.querySelector( '[data-tm-book-signup]' );
		var follow = wrap.querySelector( '.tm-followup' );
		var error = wrap.querySelector( '.tm-signup-error' );
		if ( ! form ) {
			return;
		}
		form.addEventListener( 'submit', function ( e ) {
			e.preventDefault();
			var email = form.querySelector( 'input[type=email]' ).value;
			var button = form.querySelector( 'button' );
			function done() {
				form.hidden = true;
				error.hidden = true;
				follow.hidden = false;
				follow.dataset.email = email;
			}
			if ( ! cfg.mailerliteUrl ) {
				done();
				return;
			}
			var data = new FormData();
			data.append( 'fields[email]', email );
			data.append( 'ml-submit', '1' );
			data.append( 'anticsrf', 'true' );
			button.disabled = true;
			fetch( cfg.mailerliteUrl, { method: 'POST', body: data } )
				.then( function ( r ) {
					return r.json().catch( function () {
						return { success: r.ok };
					} );
				} )
				.then( function ( res ) {
					if ( res && res.success === false ) {
						throw new Error( 'rejected' );
					}
					done();
				} )
				.catch( function ( err ) {
					if ( err && err.message === 'rejected' ) {
						error.hidden = false;
						return;
					}
					// Browser blocked reading MailerLite's reply: send again without reading it.
					return fetch( cfg.mailerliteUrl, { method: 'POST', body: data, mode: 'no-cors' } ).then( done, function () {
						error.hidden = false;
					} );
				} )
				.finally( function () {
					button.disabled = false;
				} );
		} );
		var yes = wrap.querySelector( '[data-tm-wle-yes]' );
		var no = wrap.querySelector( '[data-tm-wle-no]' );
		if ( yes ) {
			yes.addEventListener( 'click', function () {
				var url = ( cfg.substackUrl || '' ) + '/subscribe?email=' + encodeURIComponent( follow.dataset.email || '' );
				window.open( url, '_blank', 'noopener' );
				follow.innerHTML = '<p class="tm-followup-done">Almost done: confirm your subscription in the Substack tab that just opened.</p>';
			} );
		}
		if ( no ) {
			no.addEventListener( 'click', function () {
				follow.innerHTML = '<p class="tm-followup-done">You’re on the list for release news.</p>';
			} );
		}
	} );

	/* Blog: Load more posts. */
	document.querySelectorAll( '[data-tm-load-more]' ).forEach( function ( btn ) {
		var list = btn.closest( '.wp-block-shortcode, .entry-content, body' ).querySelector( '.tm-post-cards' );
		if ( ! list ) {
			return;
		}
		var step = parseInt( list.dataset.tmMore, 10 ) || 5;
		btn.addEventListener( 'click', function () {
			var hidden = list.querySelectorAll( '.tm-post-card[hidden]' );
			for ( var i = 0; i < step && i < hidden.length; i++ ) {
				hidden[ i ].hidden = false;
			}
			if ( hidden.length <= step ) {
				btn.parentElement.hidden = true;
				var archive = list.parentElement.querySelector( '.tm-archive-link' );
				if ( archive ) {
					archive.hidden = false;
				}
			}
		} );
	} );
	/* Comedy page: rotate sample jokes, three at a time. */
	document.querySelectorAll( '.tm-rotator' ).forEach( function ( box ) {
		var items = Array.prototype.slice.call( box.querySelectorAll( ':scope > .tm-joke' ) );
		var per = 3;
		if ( items.length <= per ) {
			return;
		}
		var start = 0;
		var timer = null;
		var still = window.matchMedia && window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
		function render() {
			items.forEach( function ( el, i ) {
				el.hidden = ( ( i - start + items.length ) % items.length ) >= per;
			} );
		}
		function next() {
			box.classList.add( 'is-fading' );
			setTimeout( function () {
				start = ( start + per ) % items.length;
				render();
				box.classList.remove( 'is-fading' );
			}, still ? 0 : 350 );
		}
		function play() {
			if ( ! still ) {
				clearInterval( timer );
				timer = setInterval( next, 7000 );
			}
		}
		box.classList.add( 'is-ready' );
		render();
		play();
		box.addEventListener( 'mouseenter', function () {
			clearInterval( timer );
		} );
		box.addEventListener( 'mouseleave', play );
		var more = box.parentElement.querySelector( '.tm-rot-next a' );
		if ( more ) {
			more.addEventListener( 'click', function ( e ) {
				e.preventDefault();
				next();
				play();
			} );
		}
	} );
}() );
