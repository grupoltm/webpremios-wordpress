<?php 
   
    function ltm_getBalance() {
        $screen = $_SERVER['REQUEST_URI'];
      
        if ( isset($_COOKIE['ltm_islogged']) ) {
            
                
                $url = urlbase_ltm .'/participants/me/simpleBalance';
                            
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
            
                $balance = wp_remote_post( $url, $args);
                
                $balance = json_decode($balance['body']);
                $balance = $balance->pointsValue;
                
            
        }
        return $balance;
    }
    add_action( 'init', 'ltm_getBalance', 7, 3);
	