<?php
/**
* Dwellings site custom pagination
*/

function custom_get_prev_link( $label = null ) {
    global $paged;

    if ( null === $label )
        $label = __( '&laquo;' );

    if ( !is_single() && $paged > 1 ) {
        /**
         * Filters the anchor tag attributes for the previous posts page link.
         *
         * @since 2.7.0
         *
         * @param string $attributes Attributes for the anchor tag.
         */
        $attr = apply_filters( 'previous_posts_link_attributes', '' );
        return '<a href="' . previous_posts( false ) . "\" $attr>". preg_replace( '/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label ) .'</a>';
    }
}

function custom_get_next_posts_link( $label = null, $max_page = 0 ) {
    global $paged, $wp_query;

    if ( !$max_page )
        $max_page = $wp_query->max_num_pages;

    if ( !$paged )
        $paged = 1;

    $nextpage = intval($paged) + 1;

    if ( null === $label )
        $label = __( '&raquo;' );

    if ( !is_single() && ( $nextpage <= $max_page ) ) {
        /**
         * Filters the anchor tag attributes for the next posts page link.
         *
         * @since 2.7.0
         *
         * @param string $attributes Attributes for the anchor tag.
         */
        $attr = apply_filters( 'next_posts_link_attributes', '' );

        return '<a href="' . next_posts( $max_page, false ) . "\" $attr>" . preg_replace('/&([^#])(?![a-z]{1,8};)/i', '&#038;$1', $label) . '</a>';
    }
}

function custom_numeric_posts_nav() {

if( is_singular() )
return;

global $wp_query;

/** Stop execution if there's only 1 page */
if( $wp_query->max_num_pages <= 1 )
return;

$paged = get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1;
$max   = intval( $wp_query->max_num_pages );

/**	Add current page to the array */
if ( $paged >= 1 )
$links[] = $paged;

/**	Add the pages around the current page to the array */
if ( $paged >= 3 ) {
$links[] = $paged - 1;
$links[] = $paged - 2;
}

if ( ( $paged + 2 ) <= $max ) {
$links[] = $paged + 2;
$links[] = $paged + 1;
}

echo '<div class="dwelling-pagination"><ul>' . "\n";

        /**	Previous Post Link */
        if ( custom_get_prev_link() )
        printf( '<li>%s</li>' . "\n", custom_get_prev_link() );

        /**	Link to first page, plus ellipses if necessary */
        if ( ! in_array( 1, $links ) ) {
        $class = 1 == $paged ? ' class="active"' : '';

        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( 1 ) ), '1' );

        if ( ! in_array( 2, $links ) )
        echo '<li>…</li>';
        }

        /**	Link to current page, plus 2 pages in either direction if necessary */
        sort( $links );
        foreach ( (array) $links as $link ) {
        $class = $paged == $link ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $link ) ), $link );
        }

        /**	Link to last page, plus ellipses if necessary */
        if ( ! in_array( $max, $links ) ) {
        if ( ! in_array( $max - 1, $links ) )
        echo '<li>…</li>' . "\n";

        $class = $paged == $max ? ' class="active"' : '';
        printf( '<li%s><a href="%s">%s</a></li>' . "\n", $class, esc_url( get_pagenum_link( $max ) ), $max );
        }

        /**	Next Post Link */
        if ( custom_get_next_posts_link() )
        printf( '<li>%s</li>' . "\n", custom_get_next_posts_link() );

        echo '</ul></div>' . "\n";

}