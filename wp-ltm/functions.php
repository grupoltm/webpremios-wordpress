<?php
session_start();

//error_reporting(0);

set_time_limit(0);
ini_set('max_execution_time', 0);

if (get_option('timezones') != "") {
	date_default_timezone_set(get_option('timezones'));
}


require_once(dirname(__FILE__) . '/admin/ltm-options.php');
require_once(dirname(__FILE__) . '/admin/ltm-pages.php');
require_once(dirname(__FILE__) . '/inc/ltm-options.php');
require_once(dirname(__FILE__) . '/inc/ltm-categories.php');
require_once(dirname(__FILE__) . '/inc/ltm-showcases.php');

require_once(dirname(__FILE__) . '/inc/ltm-userinfo.php');
require_once(dirname(__FILE__) . '/inc/ltm-balance.php');

require_once(dirname(__FILE__) . '/inc/ltm-prices.php');
require_once(dirname(__FILE__) . '/inc/ltm-products.php');


add_theme_support( 'post-thumbnails' ); 
add_action('after_setup_theme', 'remove_admin_bar');
 
function remove_admin_bar() {
	if (!current_user_can('administrator') && !is_admin()) {
	  show_admin_bar(false);
	}
}
/*
function wmpudev_enqueue_icon_stylesheet() {
	wp_register_style( 'fontawesome', 'http:////maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
	wp_enqueue_style( 'fontawesome');
}
add_action( 'wp_enqueue_scripts', 'wmpudev_enqueue_icon_stylesheet' );
*/

 function validPrice($availability, $valFrom, $valTo) {
	return $valTo<=$valFrom && $availability? true : false;	
}
function getPrice($valFrom, $valTo){
	$discount = $valFrom / $valTo;
	$discount = 1 - $discount;
	$discount = $discount * 100;  
	$discount = number_format($discount, 0, ',', '.');
	return $discount;
}

if ( function_exists( "register_nav_menu" ) ) {
	
	function register_menus() {
		register_nav_menus(
		array(
		  'ltm_menu_user' => __( 'Usuário' ),
		  'ltm_menu_default' => __( 'Principal' )
		)
	  );
	
		$menu_name = 'LTM - Usuário';
		$menu_exists = wp_get_nav_menu_object( $menu_name );
		if( !$menu_exists){
			$menu_id = wp_create_nav_menu($menu_name);
			set_theme_mod('nav_menu_locations', array('ltm_menu_user' => $menu_id));
			
			$array = array(
				'menu-item-title' =>  __('Meus Dados'),
				'menu-item-classes' => 'meus-dados',
				'menu-item-url' =>	esc_url( get_permalink(get_option("profile_page")) ) , 
				'menu-item-status' => 'publish');
				
			wp_update_nav_menu_item($menu_id, 0, $array);
			
			$array = array(
				'menu-item-title' =>  __('Sair'),
				'menu-item-classes' => 'sair',
				'menu-item-url' => get_permalink(esc_attr( get_option('login_page'))) . "?task=logout", 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);
		}
		$menu_name = 'LTM - Principal';
		$menu_exists = wp_get_nav_menu_object( $menu_name );
		if( !$menu_exists){
			$menu_id = wp_create_nav_menu($menu_name);
			set_theme_mod('nav_menu_locations', array('ltm_menu_default' => $menu_id));
			
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Produtos'),
				'menu-item-classes' => 'produtos',
				'menu-item-url' => esc_url( get_permalink(get_option("search_page")) ), 
				'menu-item-status' => 'publish'));

			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Lojas'),
				'menu-item-classes' => 'lojas',
				'menu-item-url' => esc_url( get_permalink(get_option("profile_page")) ), 
				'menu-item-status' => 'publish'));
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Recarga de Celular'),
				'menu-item-classes' => 'recarga-de-celular',
				'menu-item-url' => esc_url( get_permalink(get_option("profile_page")) ), 
				'menu-item-status' => 'publish'));
			wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  __('Pagamento de Contas'),
				'menu-item-classes' => 'pagamento-de-contas',
				'menu-item-url' => esc_url( get_permalink(get_option("profile_page")) ), 
				'menu-item-status' => 'publish'));
		}
		
		$menu_name = 'LTM - Meus Dados';
		$menu_exists = wp_get_nav_menu_object( $menu_name );
		if( !$menu_exists){
			$menu_id = wp_create_nav_menu($menu_name);
			
			$array = array(
				'menu-item-title' =>  __('Cadastro'),
				'menu-item-classes' => 'cadastro',
				'menu-item-url' => esc_url( get_permalink(get_option("profile_page")) ), 
				'menu-item-status' => 'publish');
				
			wp_update_nav_menu_item($menu_id, 0, $array);
			
			$array = array(
				'menu-item-title' =>  __('Carrinho'),
				'menu-item-classes' => 'carrinho',
				'menu-item-url' => esc_url( get_permalink(get_option("cart_page")) ), 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);

			$array = array(
				'menu-item-title' =>  __('Lista de Desejo'),
				'menu-item-classes' => 'lista-de-desejos',
				'menu-item-url' => esc_url( get_permalink(get_option("wishlist_page")) ), 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);

			$array = array(
				'menu-item-title' =>  __('Pedidos'),
				'menu-item-classes' => 'pedidos',
				'menu-item-url' => esc_url( get_permalink(get_option("orders_page")) ), 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);

			$array = array(
				'menu-item-title' =>  __('Extrato'),
				'menu-item-classes' => 'extrato',
				'menu-item-url' => esc_url( get_permalink(get_option("extract_page")) ), 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);
		}

		$menu_name = 'LTM - Resgate';
		$menu_exists = wp_get_nav_menu_object( $menu_name );
		if( !$menu_exists){
			$menu_id = wp_create_nav_menu($menu_name);
			
			$array = array(
				'menu-item-title' =>  __('Produtos'),
				'menu-item-classes' => 'produtos',
				'menu-item-url' => esc_url( get_permalink(get_option("search_page")) ), 
				'menu-item-status' => 'publish');
				
			wp_update_nav_menu_item($menu_id, 0, $array);
			
			$array = array(
				'menu-item-title' =>  __('Lojas'),
				'menu-item-classes' => 'lojas',
				'menu-item-url' => home_url('/'), 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);

			$array = array(
				'menu-item-title' =>  __('Recarga de Celular'),
				'menu-item-classes' => 'recarga-de-celular',
				'menu-item-url' => home_url('/'), 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);

			$array = array(
				'menu-item-title' =>  __('Pagamento de Contas'),
				'menu-item-classes' => 'pagamento-de-contas',
				'menu-item-url' => home_url('/'), 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);
		}
		
		$menu_name = 'LTM - Tire suas dúvidas';
		$menu_exists = wp_get_nav_menu_object( $menu_name );
		if( !$menu_exists){
			$menu_id = wp_create_nav_menu($menu_name);
			
			$array = array(
				'menu-item-title' =>  __('Perguntas Frequentes'),
				'menu-item-classes' => 'perguntas-frequentes',
				'menu-item-url' => esc_url( get_permalink(get_option("faq_page")) ), 
				'menu-item-status' => 'publish');
				
			wp_update_nav_menu_item($menu_id, 0, $array);
			
			$array = array(
				'menu-item-title' =>  __('Fale Conosco'),
				'menu-item-classes' => 'fale-conosco',
				'menu-item-url' => esc_url( get_permalink(get_option("contact_page")) ), 
				'menu-item-status' => 'publish');
			wp_update_nav_menu_item($menu_id, 0, $array);
		}
		
		
	}
	add_action( 'init', 'register_menus' );
}


register_post_type( 'produto',
    array(
        'labels' => array(
        'name' => _x( 'Produtos', '', 'namespace' ),
        'singular_name' => _x( 'Produto', '', 'namespace' ),
        'add_new' => __( 'Adicionar novo produto', 'namespace' ),
        'add_new_item' => __( 'Adicionar novo produto', 'namespace' ),
        'edit_item' => __( 'Editar Produto', 'namespace' ),
        'new_item' => __( 'Novo Produto', 'namespace' ),
        'view_item' => __( 'Visualizar', 'namespace' ),
        'search_items' => __( 'Buscar', 'namespace' ),
        'not_found' => __( 'Nenhum produto encontrado', 'namespace' ),
        'not_found_in_trash' => __( 'Lixo vazio', 'namespace' ),
        'parent_item_colon' => ''
    ),
    'description' => "Produtos",
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_in_menu' => true,
    'show_in_admin_bar' => true,
    'rewrite' => array( 'slug' => 'product' ),
));


register_post_type( 'pedido',
    array(
        'labels' => array(
        'name' => _x( 'Pedidos', '', 'namespace' ),
        'singular_name' => _x( 'Pedido', '', 'namespace' ),
        'add_new' => __( 'Adicionar novo Pedido', 'namespace' ),
        'add_new_item' => __( 'Adicionar novo Pedido', 'namespace' ),
        'edit_item' => __( 'Editar Pedido', 'namespace' ),
        'new_item' => __( 'Novo Pedido', 'namespace' ),
        'view_item' => __( 'Visualizar', 'namespace' ),
        'search_items' => __( 'Buscar', 'namespace' ),
        'not_found' => __( 'Nenhum Pedido encontrado', 'namespace' ),
        'not_found_in_trash' => __( 'Lixo vazio', 'namespace' ),
        'parent_item_colon' => ''
    ),
    'description' => "Pedidos",
    'public' => true,
    'exclude_from_search' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_in_menu' => true,
    'show_in_admin_bar' => true,
    'rewrite' => array( 'slug' => 'pedido' ),
));

function get_product_url($sku = "", $title = "") {
	$url = "#";
	if ($sku != "") {
		$args = array (
			'post_type'              => 'produto',
			'posts_per_page'         => '1',
			'meta_query'             => array(
				array(
					'key'       => 'sku',
					'value'     => $sku,
				),
			),
		);

		$produtos = new WP_Query( $args );
		
		if (count($produtos->posts) > 0) {
			$url = get_permalink($produtos->posts[0]->ID);
		} else {
			$my_post = array(
				'post_title'    => trim($title),
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type' => "produto"
			);
			 
			$post_id = wp_insert_post( $my_post );
			add_post_meta($post_id, 'sku', $sku, true);
			$url = get_permalink($post_id);
		}
	}
	return $url;
}
 
function get_order_url($pedido = "", $title = "") {
	$url = "#";
	if ($pedido != "") {
		$args = array (
			'post_type'              => 'pedido',
			'posts_per_page'         => '1',
			'meta_query'             => array(
				array(
					'key'       => 'pedido',
					'value'     => $pedido,
				),
			),
		);

		$produtos = new WP_Query( $args );
		
		if (count($produtos->posts) > 0) {
			$url = get_permalink($produtos->posts[0]->ID);
		} else {
			$my_post = array(
				'post_title'    => trim($title),
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type' => "pedido"
			);
			 
			$post_id = wp_insert_post( $my_post );
			add_post_meta($post_id, 'pedido', $pedido, true);
			$url = get_permalink($post_id);
		}
	}
	return $url;
}
 
function widget_footer() {
	unregister_sidebar('sidebar-1');
	$widgets = array(
		'name'          => 'Footer - Área 1',
		'id'            => 'widget_1_footer',
		'before_widget' => '<div class="col-12 col-md-3 my-3 contact widget_1_footer">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	);
	register_sidebar( $widgets );
	$widgets = array(
		'name'          => 'Footer - Área 2',
		'id'            => 'widget_2_footer',
		'before_widget' => '<div class="col-12 col-md-3 my-3 contact widget_2_footer">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	);
	register_sidebar( $widgets );
	$widgets = array(
		'name'          => 'Footer - Área 3',
		'id'            => 'widget_3_footer',
		'before_widget' => '<div class="col-12 col-md-3 my-3 contact widget_3_footer">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	);
	register_sidebar( $widgets );
	$widgets = array(
		'name'          => 'Footer - Área 4',
		'id'            => 'widget_4_footer',
		'before_widget' => '<div class="col-12 col-md-3 my-3 contact widget_4_footer">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	);
	register_sidebar( $widgets );
}
add_action( 'widgets_init', 'widget_footer' );

function slider_area() {
	$widgets = array(
		'name'          => 'Slider',
		'id'            => 'slider_area',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	);
	register_sidebar( $widgets );
}
add_action( 'widgets_init', 'slider_area' );

function profile_area() {
	$widgets = array(
		'name'          => 'Profile',
		'id'            => 'profile_area',
		'before_widget' => '<div id="category-list" class="my-4 border-top sub-category-list">',
		'after_widget'  => '</div>',
		'before_title'  => '<h2>',
		'after_title'   => '</h2>',
	);
	register_sidebar( $widgets );
}
add_action( 'widgets_init', 'profile_area' );

function slugify ($text) {

    $replace = [
        '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
        '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä'=> 'Ae',
        '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
        'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
        'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
        'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
        'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
        'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
        'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
        'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
        'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
        'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
        'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
        'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
        'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
        '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
        'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
        'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
        'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
        'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
        'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
        'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
        'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
        'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
        'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
        'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
        'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
        'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
        '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
        'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
        'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
        'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
        'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
        'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
        'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
        'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
        'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
        'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
        'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
        'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
        'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
        'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
        'ю' => 'yu', 'я' => 'ya'
    ];

    $text = strtr($text, $replace);

    $text = preg_replace('~[^\\pL\d.]+~u', '-', $text);

    $text = trim($text, '-');
	$text = preg_replace('~[^-\w.]+~', '', $text);
	$text = strtolower($text);

    return $text;
}

add_action('switch_theme', 'deactivationfunction', 1 , 2);
function deactivationfunction() {
	delete_option("ltm_categories");
	delete_option("ltm_next");
}
