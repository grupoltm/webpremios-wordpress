<?php 
        function get_details($sku){
			
				$url = urlbase_ltm .'/products/skus/' . $sku;
					
				               
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
				$products = wp_remote_post( $url, $args);
				$products = json_decode($products['body']);
				
				return $products;
		}
		

		function ltm_getProducts($array = array()) {
			
			if (!isset($array['sort'])) {
				$array['sort'] = "POPULARITY";
			}
			if (!isset($array['_offset'])) {
				$array['_offset'] = 0;
			}
			if (!isset($array['_limit'])) {
				$array['_limit'] = 25;
			}

			$gets = array();
			foreach ($array as $key=>$item) {
				$gets[] = $key . "=" . $item;
			}


			$url = urlbase_ltm .'/products?' . implode("&", $gets);
			
			
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
			
			$products = wp_remote_post( $url, $args);
			
			return $products;
		}
		function ltm_getWishlist($array = array()) {
			
			$wishlistitens = array();
			if (isset($_COOKIE['wishlistitens'])) {
				$wishlistitens = $_COOKIE['wishlistitens'];
				if ($wishlistitens != "")
					$wishlistitens = explode("|", $wishlistitens);
			}

			$products = array();
			$products['response']['code'] = "";
			
			
			if (count($wishlistitens) > 0) {
				foreach ($wishlistitens as $w) {
					if ($w != "") {
						$url = urlbase_ltm .'/products/skus/' . $w;
						
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
						
						$return = wp_remote_post( $url, $args);
												
						$response = $return['response']['code'];

						if ($response == 200) {
							$products['response']['code'] = 200;
							$return = json_decode( $return['body'] );
							
							$products['products'][] = $return;
						}
					}
				}
			}
			return $products;
		}

		function ltm_addCart() {
			if (isset($_POST['sku']) && isset($_POST['vendorId']) && isset($_POST['cart'])){			
				
				$url = urlbase_ltm .'/carts/me/items';
					
				               
				$headers = array(
					'Content-Type' => "application/x-www-form-urlencoded",
					'Authorization' => $_COOKIE['ltm_islogged'],
					'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
				);
		
				$body = array(
					'vendorId' => esc_attr($_POST['vendorId']),
					'sku' => esc_attr($_POST['sku'])
				);
				
				$args = array(
					'method' => 'POST',
					'timeout' => 45,
					'headers' => $headers,
					'body' => $body
				);
				
				
				$cart = wp_remote_post( $url, $args);

				if ($cart['response']['code'] == 201) {
					echo "success";
				} else {
					echo "error";
				}
				exit();
			}
		}
		
		add_action( 'init', 'ltm_addCart', 10, 3);
	

		function ltm_updateCart() {
			if (isset($_POST['sku']) && isset($_POST['vendorId']) && isset($_POST['quantity'])){			
				
				$url = urlbase_ltm .'/carts/me/items/' .esc_attr($_POST['sku']);
					
				               
				$headers = array(
					'Content-Type' => "application/x-www-form-urlencoded",
					'Authorization' => $_COOKIE['ltm_islogged'],
					'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
				);
		
				$body = array(
					"vendorId" => esc_attr($_POST['vendorId']),
					"quantity" => esc_attr($_POST['quantity'])
				);
				
				$args = array(
					'method' => 'PUT',
					'timeout' => 45,
					'headers' => $headers,
					'body' => $body
				);
				$cart = wp_remote_post( $url, $args);
				if ($cart['response']['code'] == 201) {
					echo "success";
				} else {
					echo "error";
				}
				exit();
			}
		}
		
		add_action( 'init', 'ltm_updateCart', 10, 3);
	
	
		function ltm_deleteCart() {
			if (isset($_GET['deleteItem'])){			
				
				$url = urlbase_ltm .'/carts/me/items/' . $_GET['deleteItem'];
					
				$headers = array(
					'Content-Type' => "application/x-www-form-urlencoded",
					'Authorization' => $_COOKIE['ltm_islogged'],
					'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
				);
			
				$body = array();
			
				$args = array(
					'method' => 'DELETE',
					'timeout' => 45,
					'headers' => $headers,
					'body' => $body
				);
				
				
				$cart = wp_remote_post( $url, $args);
				
				
				if ($cart['response']['code'] == 204) {
					echo "success";
				} else {
					echo "error";
				}
				exit();
			}
		}
		
		add_action( 'init', 'ltm_deleteCart', 10, 3);
	
	
		function ltm_getCart() {
			//if ($idPage == esc_attr( get_option('cart_page') )) {
				$url = urlbase_ltm .'/carts/me';
					
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
				
				$cartItems = wp_remote_post( $url, $args);
				
				return isset($cartItems['body']) ? $cartItems['body'] : "error";
			//}
		}
		
		
		
		function ltm_getShipping() {
			if (isset($_POST['zipcode']) && !isset($_POST['typeshipping'])){				
				$url = urlbase_ltm .'/carts/me/shipping/rates/' .esc_attr($_POST['zipcode']);
			}
			if (isset($_POST['typeshipping'])){				
				if (esc_attr($_POST['typeshipping']) == 0) {
						$user = get_user_info($_COOKIE['ltm_islogged']);
						$user = json_decode($user['body']);
						
						$address = $user->address;
						
						$zipcode = $address->zipCode;
				} else {
					$user_id = $_COOKIE['wp_id'];
					$zipcode = get_user_meta($user_id, "zipcode", true);
				}
				
				$url = urlbase_ltm .'/carts/me/shipping/rates/' . $zipcode;
			}
			if (isset($_POST['zipcode']) || isset($_POST['typeshipping'])){
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
				
				$cart = wp_remote_post( $url, $args);
				
				
				if (@$cart['response']['code'] == 201 || @$cart['response']['code'] == 200) {
					$tax = json_decode($cart['body']);
					echo $tax->total;
					if (isset($_POST['typeshipping'])) {
						ltm_formcheckout($_POST['typeshipping']);
					}
				} else {
					echo "error";
				}
				exit();
				
			}
		}
		
		add_action( 'init', 'ltm_getShipping', 10, 3);
		
		
	function ltm_formcheckout($typeshipping = "") {
		if (isset($_POST['formcheckout']) || $typeshipping != ""){				
		
			if ($typeshipping != "") {
				$_POST['formcheckout'] = $typeshipping;
			}
			$user_id = $_COOKIE['wp_id'];
			$url = urlbase_ltm .'/carts/me/shipping';
				
			$headers = array(
				'Content-Type' => "application/x-www-form-urlencoded",
				'Authorization' => $_COOKIE['ltm_islogged'],
				'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
			);
			
	
				$user = get_user_info($_COOKIE['ltm_islogged']);
				$user = json_decode($user['body']);
				$emails = $user->emails;

				$uphones = $user->phones;
				$phones = array();
				foreach ($uphones as $k => $p) {
					if ($p->areaCode != "" && $p->number != "" && $p->type != "") {
						$phones[$k]['areaCode'] = $p->areaCode;		
						$phones[$k]['number'] = $p->number;		
						$phones[$k]['type'] = $p->type;		
						break;
					}
				}
				
				
				$customer = array (
					"name" => $user->name,
					"documentNumber"  => $user->documentNumber,
					"birthDate" => $user->birthDate,
					"genderType" => $user->genderType,
					"persontype" => $user->persontype,
					"email" => $emails[0]->email,
					"phones" => $phones
				);
				
				
				$shippingAddress = array();
				if ($_POST['formcheckout'] == 0) {
					$address = $user->address;
					
					foreach ($address as $k=>$a) {
						$shippingAddress[$k] = $a;
					}
					if (!isset($shippingAddress['state'])){
						$shippingAddress['state'] = "SP";
					}
					if (!isset($shippingAddress['reference'])){
						$shippingAddress['reference'] = "Sem ponto de referencia";
					}
					if (!isset($shippingAddress['complement'])){
						$shippingAddress['complement'] = "Sem complemento";
					}
				}
				if ($_POST['formcheckout'] == 1) {
					$shippingAddress['street'] = get_user_meta($user_id, "street", true);
					$shippingAddress['number'] = get_user_meta($user_id, "number", true);
					$shippingAddress['complement'] = get_user_meta($user_id, "complement", true) != "" ? get_user_meta($user_id, "complement", true) : "Sem complemento";
					$shippingAddress['district'] = get_user_meta($user_id, "district", true);
					$shippingAddress['city'] = get_user_meta($user_id, "city", true);
					$shippingAddress['state'] = get_user_meta($user_id, "state", true) != "" ? get_user_meta($user_id, "state", true) : "SP";
					$shippingAddress['zipCode'] = get_user_meta($user_id, "zipcode", true);
					$shippingAddress['reference'] = get_user_meta($user_id, "reference", true) != "" ? get_user_meta($user_id, "reference", true) : "Sem ponto de referencia";
				}
				
				$body = array(
					"customer" => $customer,
					"shippingAddress" => $shippingAddress,
				);
				
				$args = array(
					'method' => 'PUT',
					'timeout' => 45,
					'headers' => $headers,
					'body' => $body
				);
				
				
				$shipping = wp_remote_post( $url, $args);
				if ($shipping['response']['code'] == 201) {
					

				} else {
					
					echo "error";
					
				}
				
				exit();
		}
	}
		
		
		
	
