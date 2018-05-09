<?php
	
	if (isset($_GET['activated']) && is_admin()){
		$title = 'Login';
		$content = '';
		$template = 'templates/page-login.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "login_page", $page_id);

		
		
		
		$title = 'Esqueci minha senha';
		$content = '';
		$template = 'templates/page-reset.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "reset_page", $page_id);
		
		$title = 'Carrinho';
		$content = '';
		$template = 'templates/page-cart.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'cart'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "cart_page", $page_id);

		$title = 'Confirmação';
		$content = '';
		$template = 'templates/page-checkout.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'checkout'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "checkout_page", $page_id);


		$title = 'Compra realizada com sucesso!';
		$content = '';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'success'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
		
		
		update_option( "success_page", $page_id);


		
		$title = 'Buscar';
		$content = '';
		$template = 'templates/page-search.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'search'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "search_page", $page_id);



		$title = 'Meus Dados';
		$content = '';
		$template = 'templates/page-profile.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'profile'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "profile_page", $page_id);

		$title = 'Alterar Senha';
		$content = '';
		$template = 'templates/page-password.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'password'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "password_page", $page_id);
		

		$title = 'Meus Endereços';
		$content = '';
		$template = 'templates/page-address.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'address'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "address_page", $page_id);

		

		$title = 'Meus Pedidos';
		$content = '';
		$template = 'templates/page-orders.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'orders'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "orders_page", $page_id);

		$title = 'Extrato';
		$content = '';
		$template = 'templates/page-extract.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'extract'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "extract_page", $page_id);


		$title = 'Lista de Desejo';
		$content = '';
		$template = 'templates/page-wishlist.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'wishlist'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "wishlist_page", $page_id);

		$title = 'Tracking';
		$content = '';
		$template = 'templates/page-tracking.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'tracking'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "tracking_page", $page_id);
		
		$title = 'Contato';
		$content = '';
		$template = 'templates/page-contact.php';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'contact'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		
		update_option( "contact_page", $page_id);
		
		
		$title = 'Termos';
		$content = '';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'terms'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			
		
		update_option( "terms_page", $page_id);
		
		
		$title = 'Regulamento';
		$content = '';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'regulation'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			
		
		update_option( "regulation_page", $page_id);

		$title = 'Perguntas Frequentes';
		$content = '';
		$check = get_page_by_title($title);
		$data = array(
				'post_type' => 'page',
				'post_title' => $title,
				'post_content' => $content,
				'post_status' => 'publish',
				'post_author' => 1,
				'post_name' => 'faq'
		);
		if(!isset($check->ID)){
			$page_id = wp_insert_post($data);
		} else {
			$page_id = $check->ID;
		}
			
		
		update_option( "faq_page", $page_id);
	}
