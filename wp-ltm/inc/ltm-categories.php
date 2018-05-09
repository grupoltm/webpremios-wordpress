<?php 
        
    function ltm_getCategories() {
        
        $url = urlbase_ltm .'/products/categories';
                    
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
        
        $categories = wp_remote_post( $url, $args);
        return $categories;
    }
    //add_action( 'init', 'ltm_getCategories', 10, 3);
	