<?php 
        
    function ltm_getPrices($sku, $vendorID, $originalID) {
        
		if (isset($_SESSION[$sku])) {
			$price = json_decode($_SESSION[$sku]);
		} else {
		
			$url = urlbase_ltm .'/products/skus/' . $sku . '/availability?vendorid=' . $vendorID . '&originalid=' . $originalID;
			
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
			
			$price = wp_remote_post( $url, $args);
			
			$price = $price['body'];
			
			$_SESSION[$sku] = $price;
			
			$price = json_decode($price);
		}
        return $price[0];
    }
    
	function ltm_apiPrice() {
        if (isset($_POST['sku']) && isset($_POST['vendorId']) && isset($_POST['originalId'])){			
			$price = ltm_getPrices($_POST['sku'], $_POST['vendorId'], $_POST['originalId']);
			$price = $price;
			echo json_encode($price);
			exit();
		}
    }
    
	
	add_action( 'init', 'ltm_apiPrice', 10, 3);
	