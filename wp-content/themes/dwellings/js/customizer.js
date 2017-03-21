/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

( function( $ ) {

	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	wp.customize( 'blogdescription', function( value ) {
		value.bind( function( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' === to ) {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '.site-title a, .site-description' ).css( {
					'clip': 'auto',
					'position': 'relative'
				} );
				$( '.site-title a, .site-description' ).css( {
					'color': to
				} );
			}
		} );
	} );

	wp.customize( 'bg-hero-learn', function( value ) {
		value.bind( function( to ) {
			0 === $.trim( to ).length ?
				$( '.map-learn-more' ).css( 'background-image', '' ) :
				$( '.map-learn-more' ).css( 'background-image', 'url( ' + to + ')' );

		});
	});

	wp.customize( 'learn-more-hero-show', function( value ) {
		value.bind( function( to ) {
			false === to ? $( '.map-learn-more' ).hide() : $( '.map-learn-more' ).show();
		} );
	} );

	wp.customize( 'learn-more-left-show', function( value ) {
		value.bind( function( to ) {
			false === to ? $( '.left-image-section' ).hide() : $( '.left-image-section' ).show();
		} );
	} );

	wp.customize( 'learn-more-right-show', function( value ) {
		value.bind( function( to ) {
			false === to ? $( '.right-image-section' ).hide() : $( '.right-image-section' ).show();
		} );
	} );

	wp.customize( 'learn-more-contact-show', function( value ) {
		value.bind( function( to ) {
			false === to ? $( '.learn-more-contact' ).hide() : $( '.learn-more-contact' ).show();
		} );
	} );
} )( jQuery );
