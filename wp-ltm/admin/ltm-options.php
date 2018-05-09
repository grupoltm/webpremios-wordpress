<?php


	define("ME_URL", rtrim(WP_PLUGIN_URL,'/') . '/'.basename(dirname(__FILE__)) );
	define("ME_DIR", rtrim(dirname(__FILE__), '/'));

	function my_admin_scripts() {
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}

	function my_admin_styles() {
		wp_enqueue_style('thickbox');
	}

	add_action('admin_print_scripts', 'my_admin_scripts');
	add_action('admin_print_styles', 'my_admin_styles');


	if ( is_admin() ){
		add_action( 'admin_menu', 'add_ltm' );
		if(isset($_COOKIE['ltm_token'])) {
			$GLOBALS['ltm_token'] = $_COOKIE['ltm_token'];
		}
	}

	function register_ltm() {
		register_setting( 'ltm-settings-group', 'currecy_name' );
		register_setting( 'ltm-settings-group', 'api_key' );
		register_setting( 'ltm-settings-group', 'api_status' );
		register_setting( 'ltm-settings-group', 'campaign_id' );
		register_setting( 'ltm-settings-group', 'profile_id' );
		register_setting( 'ltm-settings-group', 'Authorization' );
		register_setting( 'ltm-settings-group', 'urlbase_ltm' );
		register_setting( 'ltm-settings-group', 'email_ltm' );
		register_setting( 'ltm-settings-group', 'timezones' );
		
		
		define("adminarea_ltm", "1");
	}
	add_action( 'admin_init', 'register_ltm' );
	
	function getTimezones() {
		$timezones = array (
			'(GMT-11:00) Midway Island' => 'Pacific/Midway',
			'(GMT-11:00) Samoa' => 'Pacific/Samoa',
			'(GMT-10:00) Hawaii' => 'Pacific/Honolulu',
			'(GMT-09:00) Alaska' => 'US/Alaska',
			'(GMT-08:00) Pacific Time (US &amp; Canada)' => 'America/Los_Angeles',
			'(GMT-08:00) Tijuana' => 'America/Tijuana',
			'(GMT-07:00) Arizona' => 'US/Arizona',
			'(GMT-07:00) Chihuahua' => 'America/Chihuahua',
			'(GMT-07:00) La Paz' => 'America/Chihuahua',
			'(GMT-07:00) Mazatlan' => 'America/Mazatlan',
			'(GMT-07:00) Mountain Time (US &amp; Canada)' => 'US/Mountain',
			'(GMT-06:00) Central America' => 'America/Managua',
			'(GMT-06:00) Central Time (US &amp; Canada)' => 'US/Central',
			'(GMT-06:00) Guadalajara' => 'America/Mexico_City',
			'(GMT-06:00) Mexico City' => 'America/Mexico_City',
			'(GMT-06:00) Monterrey' => 'America/Monterrey',
			'(GMT-06:00) Saskatchewan' => 'Canada/Saskatchewan',
			'(GMT-05:00) Bogota' => 'America/Bogota',
			'(GMT-05:00) Eastern Time (US &amp; Canada)' => 'US/Eastern',
			'(GMT-05:00) Indiana (East)' => 'US/East-Indiana',
			'(GMT-05:00) Lima' => 'America/Lima',
			'(GMT-05:00) Quito' => 'America/Bogota',
			'(GMT-04:00) Atlantic Time (Canada)' => 'Canada/Atlantic',
			'(GMT-04:30) Caracas' => 'America/Caracas',
			'(GMT-04:00) La Paz' => 'America/La_Paz',
			'(GMT-04:00) Santiago' => 'America/Santiago',
			'(GMT-03:30) Newfoundland' => 'Canada/Newfoundland',
			'(GMT-03:00) Brasilia' => 'America/Sao_Paulo',
			'(GMT-03:00) Buenos Aires' => 'America/Argentina/Buenos_Aires',
			'(GMT-03:00) Georgetown' => 'America/Argentina/Buenos_Aires',
			'(GMT-03:00) Greenland' => 'America/Godthab',
			'(GMT-02:00) Mid-Atlantic' => 'America/Noronha',
			'(GMT-01:00) Azores' => 'Atlantic/Azores',
			'(GMT-01:00) Cape Verde Is.' => 'Atlantic/Cape_Verde',
			'(GMT+00:00) Casablanca' => 'Africa/Casablanca',
			'(GMT+00:00) Edinburgh' => 'Europe/London',
			'(GMT+00:00) Greenwich Mean Time : Dublin' => 'Etc/Greenwich',
			'(GMT+00:00) Lisbon' => 'Europe/Lisbon',
			'(GMT+00:00) London' => 'Europe/London',
			'(GMT+00:00) Monrovia' => 'Africa/Monrovia',
			'(GMT+00:00) UTC' => 'UTC',
			'(GMT+01:00) Amsterdam' => 'Europe/Amsterdam',
			'(GMT+01:00) Belgrade' => 'Europe/Belgrade',
			'(GMT+01:00) Berlin' => 'Europe/Berlin',
			'(GMT+01:00) Bern' => 'Europe/Berlin',
			'(GMT+01:00) Bratislava' => 'Europe/Bratislava',
			'(GMT+01:00) Brussels' => 'Europe/Brussels',
			'(GMT+01:00) Budapest' => 'Europe/Budapest',
			'(GMT+01:00) Copenhagen' => 'Europe/Copenhagen',
			'(GMT+01:00) Ljubljana' => 'Europe/Ljubljana',
			'(GMT+01:00) Madrid' => 'Europe/Madrid',
			'(GMT+01:00) Paris' => 'Europe/Paris',
			'(GMT+01:00) Prague' => 'Europe/Prague',
			'(GMT+01:00) Rome' => 'Europe/Rome',
			'(GMT+01:00) Sarajevo' => 'Europe/Sarajevo',
			'(GMT+01:00) Skopje' => 'Europe/Skopje',
			'(GMT+01:00) Stockholm' => 'Europe/Stockholm',
			'(GMT+01:00) Vienna' => 'Europe/Vienna',
			'(GMT+01:00) Warsaw' => 'Europe/Warsaw',
			'(GMT+01:00) West Central Africa' => 'Africa/Lagos',
			'(GMT+01:00) Zagreb' => 'Europe/Zagreb',
			'(GMT+02:00) Athens' => 'Europe/Athens',
			'(GMT+02:00) Bucharest' => 'Europe/Bucharest',
			'(GMT+02:00) Cairo' => 'Africa/Cairo',
			'(GMT+02:00) Harare' => 'Africa/Harare',
			'(GMT+02:00) Helsinki' => 'Europe/Helsinki',
			'(GMT+02:00) Istanbul' => 'Europe/Istanbul',
			'(GMT+02:00) Jerusalem' => 'Asia/Jerusalem',
			'(GMT+02:00) Kyiv' => 'Europe/Helsinki',
			'(GMT+02:00) Pretoria' => 'Africa/Johannesburg',
			'(GMT+02:00) Riga' => 'Europe/Riga',
			'(GMT+02:00) Sofia' => 'Europe/Sofia',
			'(GMT+02:00) Tallinn' => 'Europe/Tallinn',
			'(GMT+02:00) Vilnius' => 'Europe/Vilnius',
			'(GMT+03:00) Baghdad' => 'Asia/Baghdad',
			'(GMT+03:00) Kuwait' => 'Asia/Kuwait',
			'(GMT+03:00) Minsk' => 'Europe/Minsk',
			'(GMT+03:00) Nairobi' => 'Africa/Nairobi',
			'(GMT+03:00) Riyadh' => 'Asia/Riyadh',
			'(GMT+03:00) Volgograd' => 'Europe/Volgograd',
			'(GMT+03:30) Tehran' => 'Asia/Tehran',
			'(GMT+04:00) Abu Dhabi' => 'Asia/Muscat',
			'(GMT+04:00) Baku' => 'Asia/Baku',
			'(GMT+04:00) Moscow' => 'Europe/Moscow',
			'(GMT+04:00) Muscat' => 'Asia/Muscat',
			'(GMT+04:00) St. Petersburg' => 'Europe/Moscow',
			'(GMT+04:00) Tbilisi' => 'Asia/Tbilisi',
			'(GMT+04:00) Yerevan' => 'Asia/Yerevan',
			'(GMT+04:30) Kabul' => 'Asia/Kabul',
			'(GMT+05:00) Islamabad' => 'Asia/Karachi',
			'(GMT+05:00) Karachi' => 'Asia/Karachi',
			'(GMT+05:00) Tashkent' => 'Asia/Tashkent',
			'(GMT+05:30) Chennai' => 'Asia/Calcutta',
			'(GMT+05:30) Kolkata' => 'Asia/Kolkata',
			'(GMT+05:30) Mumbai' => 'Asia/Calcutta',
			'(GMT+05:30) New Delhi' => 'Asia/Calcutta',
			'(GMT+05:30) Sri Jayawardenepura' => 'Asia/Calcutta',
			'(GMT+05:45) Kathmandu' => 'Asia/Katmandu',
			'(GMT+06:00) Almaty' => 'Asia/Almaty',
			'(GMT+06:00) Astana' => 'Asia/Dhaka',
			'(GMT+06:00) Dhaka' => 'Asia/Dhaka',
			'(GMT+06:00) Ekaterinburg' => 'Asia/Yekaterinburg',
			'(GMT+06:30) Rangoon' => 'Asia/Rangoon',
			'(GMT+07:00) Bangkok' => 'Asia/Bangkok',
			'(GMT+07:00) Hanoi' => 'Asia/Bangkok',
			'(GMT+07:00) Jakarta' => 'Asia/Jakarta',
			'(GMT+07:00) Novosibirsk' => 'Asia/Novosibirsk',
			'(GMT+08:00) Beijing' => 'Asia/Hong_Kong',
			'(GMT+08:00) Chongqing' => 'Asia/Chongqing',
			'(GMT+08:00) Hong Kong' => 'Asia/Hong_Kong',
			'(GMT+08:00) Krasnoyarsk' => 'Asia/Krasnoyarsk',
			'(GMT+08:00) Kuala Lumpur' => 'Asia/Kuala_Lumpur',
			'(GMT+08:00) Perth' => 'Australia/Perth',
			'(GMT+08:00) Singapore' => 'Asia/Singapore',
			'(GMT+08:00) Taipei' => 'Asia/Taipei',
			'(GMT+08:00) Ulaan Bataar' => 'Asia/Ulan_Bator',
			'(GMT+08:00) Urumqi' => 'Asia/Urumqi',
			'(GMT+09:00) Irkutsk' => 'Asia/Irkutsk',
			'(GMT+09:00) Osaka' => 'Asia/Tokyo',
			'(GMT+09:00) Sapporo' => 'Asia/Tokyo',
			'(GMT+09:00) Seoul' => 'Asia/Seoul',
			'(GMT+09:00) Tokyo' => 'Asia/Tokyo',
			'(GMT+09:30) Adelaide' => 'Australia/Adelaide',
			'(GMT+09:30) Darwin' => 'Australia/Darwin',
			'(GMT+10:00) Brisbane' => 'Australia/Brisbane',
			'(GMT+10:00) Canberra' => 'Australia/Canberra',
			'(GMT+10:00) Guam' => 'Pacific/Guam',
			'(GMT+10:00) Hobart' => 'Australia/Hobart',
			'(GMT+10:00) Melbourne' => 'Australia/Melbourne',
			'(GMT+10:00) Port Moresby' => 'Pacific/Port_Moresby',
			'(GMT+10:00) Sydney' => 'Australia/Sydney',
			'(GMT+10:00) Yakutsk' => 'Asia/Yakutsk',
			'(GMT+11:00) Vladivostok' => 'Asia/Vladivostok',
			'(GMT+12:00) Auckland' => 'Pacific/Auckland',
			'(GMT+12:00) Fiji' => 'Pacific/Fiji',
			'(GMT+12:00) International Date Line West' => 'Pacific/Kwajalein',
			'(GMT+12:00) Kamchatka' => 'Asia/Kamchatka',
			'(GMT+12:00) Magadan' => 'Asia/Magadan',
			'(GMT+12:00) Marshall Is.' => 'Pacific/Fiji',
			'(GMT+12:00) New Caledonia' => 'Asia/Magadan',
			'(GMT+12:00) Solomon Is.' => 'Asia/Magadan',
			'(GMT+12:00) Wellington' => 'Pacific/Auckland',
			'(GMT+13:00) Nuku\'alofa' => 'Pacific/Tongatapu'
			);

		return $timezones;
	}

	function load_ltm() {
		
		if (!isset($GLOBALS['ltm_token'])) {
			get_access_token();
		} else {
			if (isset($_POST['api_key']) && isset($_POST['campaign_id'])) {
				setcookie( 'ltm_token', $_POST['api_key'], time() + (1));
			}
		}
	}
	function add_ltm() {
		add_action('admin_head', 'head_ltm');
		add_menu_page('Webpremios', 'LTM - Config', 'administrator', 'dashboard_ltm', 'dashboard_page_ltm' , get_template_directory_uri() . '/assets/img/ltm/favicon-16x16.png', 0 );
		add_action( 'admin_init', 'register_ltm' );
		add_action( 'admin_init', 'load_ltm' );
	}
	
	
	function ltm_cache() {
		if (isset($_GET['cache']) && isset($_GET['page'])) {
			if ($_GET['cache'] == 'categories' && $_GET['page'] == 'dashboard_ltm') {
				update_option( 'ltm_next', 0);
			}
		}
	}
	add_action( 'init', 'ltm_cache', 0, 9 );


	function dashboard_page_ltm() {
		require("options/dashboard.php");
	}
	function head_ltm() {
		require("options/head.php");
	}
	
	function get_access_token(){
		$url = urlbase_ltm .'/access-token'; // /cloudloyalty/v1/access-token
			
		$headers = array(
			'Content-Type' => "application/x-www-form-urlencoded",
			'Authorization' => get_option('Authorization'),
			'Ocp-Apim-Subscription-Key' => esc_attr( get_option('api_key') )
		);
		$body = array(
			'grant_type' => "client_credentials",
			'campaign_id' => esc_attr( get_option('campaign_id') )
		);
		
		$args = array(
			'method' => 'POST',
			'timeout' => 45,
			'headers' => $headers,
			'body' => $body
		);
		$access_token = wp_remote_post( $url, $args);
		

		if (isset($access_token['body'])){
			$body = json_decode($access_token['body']);
		}
		if (!isset($body->access_token)) {
			update_option( "api_status", "0");
		} else {
			setcookie( 'ltm_token', $body->access_token, time() + (3600 * 2));
			update_option( "api_status", "1");
		
		}
		
		$GLOBALS['ltm_token'] = $body->access_token;		
	}
	
	
	
	function ltm_defines() {
		define('urlbase_ltm', (get_option("urlbase_ltm") != "" ? get_option("urlbase_ltm") : 'https://cloudloyaltyapimanprd.azure-api.net/cloudloyalty/v1' ));
	}
	add_action( 'init', 'ltm_defines', 0, 3 );
	
	