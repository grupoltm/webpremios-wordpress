<?php
	
	if (isset($_GET['activated']) && is_admin()){
		$title = 'Cloud Loyalty - Login';
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
			if(!empty($template)){
				update_post_meta($page_id, '_wp_page_template', $template);
			}
		}
		update_option( "login_page", $page_id);
	}