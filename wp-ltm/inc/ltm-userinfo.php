<?php 
    function ltm_getUserinfo() {
        
        if (isset($_COOKIE['userInfo'])) {
			
			$userinfo = $_COOKIE['userInfo'];
			parse_str($userinfo, $userinfo);
		} else {
		
		
			$url = urlbase_ltm .'/participants/me';
						
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
			
			$userinfo = wp_remote_post( $url, $args);
			if ($userinfo['response']['code'] == 200 || $userinfo['response']['code'] == 201 ) {
				$userinfo = json_decode($userinfo['body']);
			
				$userinfo = http_build_query($userinfo);
				//error_reporting(0);
				//setcookie( 'userInfo', $userinfo, time() + (3600 * 2), "/");
				
				parse_str($userinfo, $userinfo);

			
			} else {
				$userinfo['name'] = "";
			}
		}
        return $userinfo;
    }
    
	
	
	
	function ltm_addAddress() {
        
		if (isset($_POST['action']) && $_POST['action'] == 'novo-endereco')	{

			
			$user = get_user_info($_COOKIE['ltm_islogged']);
			$user = json_decode($user['body']);
			
			$args = array(
				'meta_key'     => 'ltm_id',
				'meta_value'   => $user->id
			); 
			$get_users = get_users( $args );
			
			$wp_id = $get_users[0];
			$wp_id = $wp_id->ID;

			setcookie( 'wp_id', $wp_id, time() + (3600 * 2), "/");
		
			$user_id = $wp_id;
			
			
			add_user_meta( $user_id, "street", esc_attr($_POST['endereco']));
			add_user_meta( $user_id, "number", esc_attr($_POST['numero']));
			add_user_meta( $user_id, "complement", esc_attr($_POST['complemento']));
			add_user_meta( $user_id, "zipcode", esc_attr($_POST['cep']));
			add_user_meta( $user_id, "district", esc_attr($_POST['bairro']));
			add_user_meta( $user_id, "city", esc_attr($_POST['cidade']));
			add_user_meta( $user_id, "state", esc_attr($_POST['UF']));
			
		}
        
        
    }
    add_action( 'init', 'ltm_addAddress', 10, 3);
	
	function ltm_checkout() {
        
		if (isset($_POST['action']) && $_POST['action'] == 'checkout')	{

			
			$url = urlbase_ltm .'/purchases';
						
			$headers = array(
				'Content-Type' => "application/x-www-form-urlencoded",
				'Authorization' => $_COOKIE['ltm_islogged'],
				'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
			);
		
			$body = array(
				"channelType" => "ONLINE"
			);
		
			$args = array(
				'method' => 'POST',
				'timeout' => 100,
				'headers' => $headers,
				'body' => $body
			);
			
			$purchases = wp_remote_post( $url, $args);
			
			if ($purchases['response']['code'] == 200 || $purchases['response']['code'] == 201 ) {
				wp_redirect(get_permalink(esc_attr( get_option('success_page'))));
			} else {
				wp_redirect(get_permalink(esc_attr( get_option('checkout_page'))) . "?erro=Não+foi+possivel");
			}
			exit();
			
		}
        
        
    }
    add_action( 'init', 'ltm_checkout', 10, 3);
	
	
	
	
	