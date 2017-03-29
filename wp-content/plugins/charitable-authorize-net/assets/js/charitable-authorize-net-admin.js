( function( $ ){

    $( '.charitable-anet-sync-button' ).on( 'click', function() {
        
        var $button = $( this ),
            default_text = $button.html();

        $button.addClass( 'updating' ).html( '<span class="dashicons dashicons-update"></span>' + CHARITABLE_ANET_ADMIN_VARS.syncing );

        $.ajax({
            type: "POST", 
            data: {
                action: 'charitable_sync_authorize_net_fields'
            }, 
            url: ajaxurl, 
            xhrFields: {
                withCredentials: true
            }, 
            success: function( response ) {             
                if ( window.console && window.console.log ) {
                    console.log( response );
                }

                $( '.charitable-anet-sync-time-ago' ).text( CHARITABLE_ANET_ADMIN_VARS.synced_just_now );
                                
                $button.html( default_text ).removeClass( 'updating' );

            }
        }).fail(function (data) {
            if ( window.console && window.console.log ) {
                console.log( data );
            }
        });        

        return false;
    });
    
})( jQuery );