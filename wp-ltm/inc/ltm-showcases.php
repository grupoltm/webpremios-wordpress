<?php 
        
    function ltm_getShowcase() {
        
        $url = urlbase_ltm .'/showcases/home?_offset=0';
                    
        $headers = array(
            'Content-Type' => "application/x-www-form-urlencoded",
            'Authorization' => $_COOKIE['ltm_islogged'],
            'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
        );
    
        $body = array();

        $args = array(
            'method' => 'GET',
            'timeout' => 45,
            'headers' => $headers,
            'body' => $body
        );
        
        $showcase = wp_remote_post( $url, $args);
        
        return $showcase;
        
    }
    //add_action( 'init', 'ltm_getShowcase', 10, 3);