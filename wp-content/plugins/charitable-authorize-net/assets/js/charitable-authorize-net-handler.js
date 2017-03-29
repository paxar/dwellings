( function( $, window ) {

    var $body = $( 'body' ),
        $helper;

    /**
     * Process the Accept.JS response.
     */
    window.charitable_process_acceptjs_response = function( response ) {

        if ( 'Error' === response.messages.resultCode ) {
            for ( var i = 0; i < response.messages.message.length; i++ ) {
                $helper.add_error( response.messages.message[i].text );
            }
        } else {
            $helper.get_input( 'anet_token' ).val( response.opaqueData.dataValue );
            $helper.get_input( 'anet_token_description' ).val( response.opaqueData.dataDescriptor );
            $body.trigger( 'charitable:form:process', $helper );
        }

    } 

    /**
     * Handle Accept.JS donations.
     */
    var accept_js_handler = function() {        

        /**
         * Validate form submission.
         */
        var validate = function( event, helper ) {
            
            var cc_number = helper.get_cc_number().replace( / /g, '' ), 
                cc_cvc = helper.get_cc_cvc(), 
                cc_expiry_month = helper.get_cc_expiry_month(), 
                cc_expiry_year = helper.get_cc_expiry_year(),
                zip = helper.get_input( 'postcode' ).val() || '';

            $helper = helper;

            // Remove credit card field names
            helper.clear_cc_fields();

            // If we're not using Authorize.Net, do not process any further
            if ( 'authorize_net' !== helper.get_payment_method() ) {
                return;
            }

            event.preventDefault();

            // If we have found no errors, create a token with Stripe
            if ( helper.errors.length === 0 ) {

                helper.pause_processing = true;

                Accept.dispatchData( {
                    authData : {
                        clientKey  : CHARITABLE_ANET_VARS.client_key, 
                        apiLoginID : CHARITABLE_ANET_VARS.api_login_id
                    },
                    cardData : {
                        cardNumber : cc_number,
                        month      : cc_expiry_month,
                        year       : cc_expiry_year,
                        cardCode   : cc_cvc,
                        zip        : zip
                    }
                }, 'charitable_process_acceptjs_response' );

            }
        }

        $body.on( 'charitable:form:validate', validate );

    }

    /**
     * Initialize the Accept.JS handlers. 
     *
     * The 'charitable:form:initialize' event is only triggered once.
     */    
    $body.on( 'charitable:form:initialize', function( event, helper ) {

        accept_js_handler( event, helper );

    });


})( jQuery, window );

