<?php
	session_start();

	
	function ltm_ajax() {
		global $wpdb;
		$err = '';
		$success = '';
		if(isset($_POST['wishlist']) ){
			$wishlist = get_user_meta( $_COOKIE['wp_id'], 'wishlist', true );
			if (isset($wishlist) && $wishlist != "") {
				$wishlist = explode("|",$wishlist);
				$itens = array();
				foreach ($wishlist as $w) {
					if ($w != "") {
						$itens[$w] = $w;
					}
				}
				if (in_array($_POST['wishlist'], $itens)) {
					unset($itens[$_POST['wishlist']]);
				} else {
					$itens[] = $_POST['wishlist'];
				}
				$wishlist = implode("|", $itens);
				update_user_meta( $_COOKIE['wp_id'], 'wishlist', $wishlist );
			} else {
				$wishlist = $_POST['wishlist'];
				add_user_meta( $_COOKIE['wp_id'], 'wishlist', $_POST['wishlist'] );
			}
			setcookie( 'wishlistitens', $wishlist, time() + (3600 * 2), "/");
			exit();
		}
		
		if(isset($_GET['task']) && $_GET['task'] == 'ajax_variant' ){
			$retorno = array();
			if (isset($_GET['sku'])) {
				$array = $_GET['sku'];
				$array = explode(",", $array);
				foreach ($array as $ar) {
					$detail = get_details($ar);
					$skus = $detail->skus;
				}
			} else {
				$retorno["erro"] = "SKU não encontrado";
			}
			echo json_encode($retorno);
			exit();
		}
		if(isset($_GET['task']) && $_GET['task'] == 'ajax_price' ){
			$retorno = array();
			if (isset($_GET['sku'])) {
				$array = $_GET['sku'];
				$array = explode(",", $array);

				$infos = $_GET['infos'];
				$infos = explode(",", $infos);
				
				foreach ($array as $ar) {
					$price = ltm_getPrices($ar, $infos[0], $infos[1] );
					$price = json_decode( $price['body'] );
					$retorno["price"] = $price[0]->price;
					$retorno["regularPrice"] = $price[0]->regularPrice;
					$retorno["available"] = $price[0]->available;
					
				}
			} else {
				$retorno["erro"] = "SKU não encontrado";
			}
			echo json_encode($retorno);
			exit();
		}
	}
	add_action( 'init', 'ltm_ajax', 10, 3 );
	
	function ltm_profile() {
		global $wpdb;
		$err = '';
		$success = '';
		
		if(isset($_POST['task']) && $_POST['task'] == 'profile' ){
			
			
			
			
			$getUser = get_user_info($_COOKIE['ltm_islogged']);
			$getUser = json_decode($getUser['body']);
			
			
			
			$fields = array();
			
			$fields['profileId'] = get_option('profile_id');
			//$fields['persontype'] = $getUser->persontype;
			$fields['status'] = $getUser->status;
			
			
			$fields['name'] = addslashes(trim($_POST['name']));
			//$fields['username'] = addslashes(trim($_POST['username']));
			$fields['documentNumber'] = addslashes(trim($_POST['documentNumber']));
			
			$fields['rg'] = addslashes(trim($_POST['rg']));
			$fields['birthDate'] = date("o\-m\-d\TH\:i\:s\.uP", strtotime(implode("-", array_reverse( explode("/", $_POST['birthDate'])))));
			
			$fields['genderType'] = $_POST['genderType'];
			$fields['maritalStatus'] = addslashes(trim($_POST['maritalStatus']));
			
			$fields['emails'] = $getUser->emails;
			$fields['phones'] = $getUser->phones;
			$fields['address'] = $getUser->address;
			
			$url = urlbase_ltm .'/participants/me';
				
			$headers = array(
				'Content-Type' => "application/x-www-form-urlencoded",
				'Authorization' => $_COOKIE['ltm_islogged'],
				'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
			);

			$body = $fields;
			
			
			$args = array(
				'method' => 'PUT',
				'timeout' => 45,
				'headers' => $headers,
				'body' => $body
			);
			
			
			
			$participants = wp_remote_post( $url, $args);
			$retorno = get_permalink(esc_attr( get_option('profile_page')));
			unset($_POST);
			if ($participants['response']['code'] == 204) {
				wp_redirect($retorno . "?r=1");
			} else {
				wp_redirect($retorno . "?r=2");
			}
			exit();
		}
	}
	add_action( 'init', 'ltm_profile', 10, 3 );
	
	function ltm_password() {
		global $wpdb;
		$err = '';
		$success = '';
		
		if(isset($_POST['task']) && $_POST['task'] == 'password' ){
			
			
			
			
			$getUser = get_user_info($_COOKIE['ltm_islogged']);
			$getUser = json_decode($getUser['body']);
			
			
			
			$fields = array();
			
			$fields['oldPassword'] = trim(addslashes($_POST['oldPassword']));
			
			$fields['newPassword'] = trim(addslashes($_POST['newPassword']));
			$fields['repeatNewPassword'] = trim(addslashes($_POST['repeatNewPassword']));
			if ($fields['newPassword'] != $fields['repeatNewPassword']) {
				wp_redirect($retorno . "?r=2");
				exit();
			}
			
			$url = urlbase_ltm .'/participants/me/password';
				
			$headers = array(
				'Content-Type' => "application/x-www-form-urlencoded",
				'Authorization' => $_COOKIE['ltm_islogged'],
				'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
			);
			
			unset($fields['repeatNewPassword']);
			$body = $fields;
			
			
			$args = array(
				'method' => 'PUT',
				'timeout' => 45,
				'headers' => $headers,
				'body' => $body
			);
			
			
			
			$participants = wp_remote_post( $url, $args);
			
			$retorno = get_permalink(esc_attr( get_option('password_page')));
			unset($_POST);
			if ($participants['response']['code'] == 204) {
				wp_redirect($retorno . "?r=1");
			} else {
				wp_redirect($retorno . "?r=2");
			}
			exit();
		}
	}
	add_action( 'init', 'ltm_password', 10, 3 );
	
	function ltm_extract($start = "", $end = "") {
		
		global $wpdb;
		$err = '';
		$success = '';
		
		$start = implode('-', array_reverse(explode("/", $start)));
		$end = implode('-', array_reverse(explode("/", $end)));
		
		$url = urlbase_ltm .'/participants/me/extract?startDate='. $start .'&endDate='. $end .'&_offset=0&_limit=200';
							
		$headers = array(
			'Accept' => "application/json",
			'Content-Type' => "application/json",
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
		
		$extract = wp_remote_post( $url, $args);	

		
		return $extract;
	}
	function ltm_order() {
		
		global $wpdb;
		$err = '';
		$success = '';
		
		
		$url = urlbase_ltm .'/purchases/me';
							
		$headers = array(
			'Accept' => "application/json",
			'Content-Type' => "application/json",
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
		
		$order = wp_remote_post( $url, $args);	
		
		
		return $order;
	}
	function ltm_tracking($pedido) {
		
		global $wpdb;
		$err = '';
		$success = '';
		
		
		$url = urlbase_ltm .'/tracking/' . $pedido;
			/*
			'Accept' => "application/json",
			'Content-Type' => "application/json",
			*/
			
		$headers = array(
			'Authorization' => $_COOKIE['ltm_islogged'],	
			'Accept' => "application/json",
			'Content-Type' => "application/json",
			'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
		);

		
		$body = array();

		$args = array(
			'method' => 'GET',
			'timeout' => 45,
			'headers' => $headers,
			'body' => $body
		);
		
		$tracking = wp_remote_post( $url, $args);	
		
		
		return $tracking;
	}
	
	function ltm_address() {
		global $wpdb;
		$err = '';
		$success = '';
		
		if(isset($_POST['task']) && $_POST['task'] == 'address' ){
			
			$getUser = get_user_info($_COOKIE['ltm_islogged']);
			$getUser = json_decode($getUser['body']);
			
			if ($_POST['item'] == 1) {
				$fields = array();
				
				
				
				$fields['profileId'] = get_option('profile_id');
				$fields['status'] = $getUser->status;
				
				
				$fields['name'] = $getUser->name;
				$fields['documentNumber'] = $getUser->documentNumber;
				
				$fields['rg'] = $getUser->rg;
				$fields['birthDate'] = $getUser->birthDate;
				
				$fields['genderType'] = $getUser->genderType;
				$fields['maritalStatus'] = $getUser->maritalStatus;
				
				$fields['emails'] = $getUser->emails;
				$fields['phones'] = $getUser->phones;
				
				$address = $getUser->address;
				
				$fields['address']['street'] = addslashes(trim($_POST['street']));
				$fields['address']['number'] = addslashes(trim($_POST['number']));
				$fields['address']['complement'] = addslashes(trim($_POST['complement']));
				$fields['address']['district'] = addslashes(trim($_POST['district']));
				$fields['address']['city'] = addslashes(trim($_POST['city']));
				$fields['address']['state'] = addslashes(trim($_POST['state']));
				$fields['address']['zipCode'] = addslashes(trim($_POST['zipCode']));
				$fields['address']['reference'] = addslashes(trim($_POST['reference']));
				
				//street
				$url = urlbase_ltm .'/participants/me';
					
				$headers = array(
					'Content-Type' => "application/x-www-form-urlencoded",
					'Authorization' => $_COOKIE['ltm_islogged'],
					'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
				);

				$body = $fields;
				
				$args = array(
					'method' => 'PUT',
					'timeout' => 45,
					'headers' => $headers,
					'body' => $body
				);
				
				
				$participants = wp_remote_post( $url, $args);
				
			}
			$continue = false;
			if ($_POST['item'] == 2) {
				$user = $getUser;
				$args = array(
					'meta_key'     => 'ltm_id',
					'meta_value'   => $user->id
				); 
				$get_users = get_users( $args );
				
				$wp_id = $get_users[0];
				$wp_id = $wp_id->ID;

				setcookie( 'wp_id', $wp_id, time() + (3600 * 2), "/");
			
				$user_id = $wp_id;
				
				
				update_user_meta( $user_id, "street", esc_attr($_POST['street']));
				update_user_meta( $user_id, "number", esc_attr($_POST['number']));
				update_user_meta( $user_id, "complement", esc_attr($_POST['complement']));
				update_user_meta( $user_id, "zipcode", esc_attr($_POST['zipCode']));
				update_user_meta( $user_id, "district", esc_attr($_POST['district']));
				update_user_meta( $user_id, "city", esc_attr($_POST['city']));
				update_user_meta( $user_id, "state", esc_attr($_POST['state']));
				$continue = true;
			}
			$retorno = get_permalink(esc_attr( get_option('address_page')));
			unset($_POST);
			if ($participants['response']['code'] == 204 || $continue = true) {
				wp_redirect($retorno . "?r=1");
			} else {
				wp_redirect($retorno . "?r=2");
			}
			exit();
		}
	}
	add_action( 'init', 'ltm_address', 10, 3 );
	
	function ltm_contact() {
		global $wpdb;
		$err = '';
		$success = '';
		
		if(isset($_POST['task']) && $_POST['task'] == 'contact' ){
			
			$headers = "MIME-Version: 1.1\r\n";
			$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
			$headers .= "From: ". get_option("email_ltm") ."\r\n"; // remetente
			$headers .= "Return-Path: ". get_option("email_ltm") ."\r\n"; // return-path
			
			$name = strip_tags(trim($_POST['name']));
			$email = strip_tags(trim($_POST['email']));
			$subject = strip_tags(trim($_POST['subject']));
			$message = strip_tags(trim($_POST['message']));
			
			$msg = array();
			$msg[] = "Nome: " . $name;
			$msg[] = "Email: " . $email;
			$msg[] = "Assunto: " . $subject;
			$msg[] = "Mensagem: " . $message;
			$msg = implode("<br />", $msg);
			
			
			$envio = mail(get_option("email_ltm"), "Contato | " . get_option("blogname"), $msg, $headers);
			
			if($envio)
				wp_redirect(get_permalink(esc_attr( get_option('contact_page'))) . "?r=1");
			else
				wp_redirect(get_permalink(esc_attr( get_option('contact_page'))) . "?r=2");
			
			exit();
		}
	}
	add_action( 'init', 'ltm_contact', 10, 3 );
	

	function ltm_logout($simple = "") {
		global $wpdb;

		$err = '';
		$success = '';

	

		if((isset($_GET['task']) && $_GET['task'] == 'logout') || $simple != ""){
			
			unset($_COOKIE['ltm_islogged']);
			unset($_COOKIE['ltm_id']);
			unset($_COOKIE['wp_id']);
			unset($_COOKIE['wishlistitens']);
			setcookie('ltm_islogged', null, -1, '/');
			setcookie('ltm_id', null, -1, '/');
			setcookie('wishlistitens', null, -1, '/');
			setcookie('wp_id', null, -1, '/');
			
			
			wp_redirect(get_permalink(esc_attr( get_option('login_page'))));
			exit();
		}
	}
	add_action( 'init', 'ltm_logout', 8, 3 );
	
	
	function ltm_login() {
		global $wpdb;

		$err = '';
		$success = '';

		if(isset($_POST['task']) && $_POST['task'] == 'login' )
		{
			
			$username = $wpdb->escape($_POST['usuario']);
			$password = $wpdb->escape($_POST['senha']);
			

			if( $username == "" || $password == "" ) {
				$err = 'Usuário ou senha inválidos';
			} else {
				
				$url = urlbase_ltm .'/access-token';
					
				$headers = array(
					'Content-Type' => "application/x-www-form-urlencoded",
					'Authorization' => get_option('Authorization'),
					'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
				);
	
				$body = array(
					'grant_type' => "password",
					'campaign_id' => esc_attr( get_option('campaign_id') ),
					'username' => $username,
					'password' => $password
				);
				
				$args = array(
					'method' => 'POST',
					'timeout' => 45,
					'headers' => $headers,
					'body' => $body
				);
				$access_token = wp_remote_post( $url, $args);


				if (isset($access_token['body'])) {
					$body = json_decode($access_token['body']);
					setcookie( 'ltm_islogged', $body->access_token, time() + (3600 * 2), "/");
					
					$user = get_user_info($body->access_token);
					$user = json_decode($user['body']);
					
					
					 $args = array(
						'meta_key'     => 'ltm_id',
						'meta_value'   => $user->id
					 ); 
					 
					$get_users = get_users( $args );

					
					if (count($get_users) == 0) {
						$emails = $user->emails;
						$user_id = wp_create_user( $user->username, $user->id, $emails[0]->email );
						
						add_user_meta( $user_id, "ltm_id", $user->id, true );
					}
					wp_redirect(get_site_url());
					exit();
				} else {
					$err = "Não foi possível efetuar o login!";
				}
				
			}
			$GLOBALS['err'] = $err;
		}
	}
	add_action( 'init', 'ltm_login', 9, 3 );
	
	function ltm_reset() {
		global $wpdb;

		$err = '';
		$success = '';

		if(isset($_POST['task']) && $_POST['task'] == 'reset' )
		{
			
			$username = $wpdb->escape($_POST['usuario']);

			if( $username == "") {
				$GLOBALS['err'] = "Usuário inválido!";
			} else {
				
				$url = urlbase_ltm .'/participants/'. $username .'/password-reset';
					
				$headers = array(
					'Content-Type' => "application/x-www-form-urlencoded",
					'Authorization' => get_option('Authorization'),
					'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
				);
		
				$body = array();
				
				$args = array(
					'method' => 'POST',
					'timeout' => 45,
					'headers' => $headers,
					'body' => $body
				);
				
				$reset = wp_remote_post( $url, $args);
				
				$crit = "";
				if ($reset['response']['code'] == 200) {
					$GLOBALS['succ'] = "Em breve você receberá um e-mail com sua nova senha!";
				} else {
					$GLOBALS['err'] = "Não foi possível recuperar a senha!";
				}	
			}
			
		}
	}
	add_action( 'init', 'ltm_reset', 9, 3 );
	
	function ltm_authenticate() {
		
		if (!is_admin() && $page->ID != esc_attr( get_option('login_page'))){
			
			$current_url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
			
			$parse_url = wp_parse_url($current_url);
			$path = array_filter(explode("/", $parse_url['path']));
			$path = end($path);
			$page = get_page_by_path( $path );
			
			if (($page->ID != esc_attr( get_option('login_page')) && $page->ID != esc_attr( get_option('reset_page'))) &&  !isset($_COOKIE['ltm_islogged'])){
				wp_redirect(get_permalink(esc_attr( get_option('login_page'))));
				exit();
			}
			
			

				if (!isset($_COOKIE['ltm_id'])) {
					$user = get_user_info($_COOKIE['ltm_islogged']);
					
					if ($user['response']['code'] == 200 || $user['response']['code'] == 201) {
						$body = json_decode($user['body']);
						setcookie( 'ltm_id', $body->id, time() + (3600 * 2), "/");
					} else {
						
					}
					
				} else {
					$user = array();
					$user['id'] = $_COOKIE['ltm_id'];
					$user = (object) $user;
				}
		
		
				$args = array(
					'meta_key'     => 'ltm_id',
					'meta_value'   => $user->id
				); 
				
				$get_users = get_users( $args );
				
				
				$wp_id = $get_users[0];
				$wp_id = $wp_id->ID;

				setcookie( 'wp_id', $wp_id, time() + (3600 * 2), "/");
				
				
			 if ($page->ID != esc_attr( get_option('login_page')) &&  !isset($_COOKIE['ltm_islogged'])){
			 	wp_redirect(get_permalink(esc_attr( get_option('login_page'))));
			 	exit();
			 }


		} else {
			
		}
		$wishlist = get_user_meta( $_COOKIE['wp_id'], 'wishlist', true );
		if (isset($wishlist) && $wishlist != "") {
			setcookie( 'wishlistitens', $wishlist, time() + (3600 * 2), "/");
		}  
	}
	
	
	
	
	function get_user_info($authorization = "") {
		$url = urlbase_ltm .'/participants/me';
		$headers = array(
			'Content-Type' => "application/x-www-form-urlencoded",
			'Authorization' => $authorization,
			'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key'))
		);
		
		$body = array();
		$args = array(
			'method' => 'GET',
			'timeout' => 45,
			'headers' => $headers,
			'body' => $body
		);
		$access_token = wp_remote_post( $url, $args);
		return $access_token;
	}
	
	
	function get_order_status ($statuss){
		switch ($statuss) {
			case "APPROVED":
				$status = "Processado pelo Fornecedor";
				break;
			case "AUTHORIZEDPAYMENT":
				$status =  "Pagamento autorizado";
				break;
			case "REFUNDED":
				$status =  "Extornado";
				break;
			case "PENDING":
				$status =  "Pendente";
				break;
			case "DELIVERED":
				$status =  "Finalizado";
				break;
			case "SENT":
				$status =  "Enviado";
				break;
			case "PARTIALREFUNDED":
				$status =  "Parcialmente estornado";
				break;
			case "PAYMENTDENIED":
				$status =  "Pagamento Negado";
				break;
			case "AUTHENTICATIONREQUIRED":
				$status =  "utenticação Requerida";
				break;
			case "AUTHENTICATIONDENIED":
				$status =  "Autenticação Negada";
				break;
			case "PAYMENTCONFIRMED":
				$status =  "Pagamento Confirmado";
				break;
			case "NOTCOMPLETED":
				$status =  "Não Concluído";
				break;
			case "PAYMENTREFUNDED":
				$status =  "Pagamento Estornado";
				break;
			case "DENIEDBYANTIFRAUD":
				$status =  "Negado na Análise de Risco";
				break;
			case "INCONSISTENTORDER":
				$status =  "Pedido inconsistente";
				break;
			case "WAITINGSUPPLIERCONFIRMATION":
				$status =  "Aguardando confirmação do fornecedor";
			break;
		}
		
		echo  $status;
	}