<?php
/**
 * The template for displaying the header
 *
 * @package WordPress
 * @subpackage wp-ltm
 * @since LTM Cloud Loyalty 1.0
 */
ltm_authenticate();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>LTM - Cloud Loyalty</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />

        <link rel="shortcut icon" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/favicon.ico" type="image/x-icon" />
        <link rel="icon" href="<?= get_template_directory_uri(); ?>/assets/img/favicon.ico" type="image/x-icon" />
        <link href="<?= get_template_directory_uri(); ?>/assets/lib/fontawesome-5.0.10/css/fontawesome-all.min.css" rel="stylesheet" />
        <link href="<?= get_template_directory_uri(); ?>/style.css" rel="stylesheet" />
        
		<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" />

        <link rel="apple-touch-icon" sizes="180x180" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/apple-touch-icon.png" />
		<link rel="icon" type="image/png" sizes="32x32" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/favicon-32x32.png" />
		<link rel="icon" type="image/png" sizes="16x16" href="<?= get_template_directory_uri(); ?>/assets/img/ltm/favicon-16x16.png" />
		<script>
			urlSite = "<?php echo get_site_url() ?>/";
			urlCart = "<?php echo get_permalink(esc_attr( get_option('cart_page'))) ?>/";
		</script> 
    <?php wp_head(); ?>
    </head>
    <body>
        <main class="container-fliud">
            <header>
                <nav>
                    <div class="container">
                        <div class="row">
                            <div class="col">
								<?php 
									$userinfo = ltm_getUserinfo();
									$balance = ltm_getBalance();
								?>
								<p id="greeting">
									Olá <strong id="username"><?= $userinfo['name']; ?></strong>,
									você tem <strong id="total-points"><?= $balance; ?></strong> 
									<span class="currency-name"><?= get_option('currecy_name'); ?></span>!
								</p>
                            </div>
                            <?php
							wp_nav_menu( array(
								'theme_location' => 'ltm_menu_user',
								'container_class' => 'col-6',
								'menu_id'         => 'nav-user'
							) );
							?>         
                        </div>
                    </div>
				</nav>
				
                <section>
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-12 col-md-3 col-lg-3">
								<div class="d-block d-md-none mobile-buttons">
								<ul>
									<li>
										<button class="cart">
											<i class="fas fa-donate"></i>

											<div class="currency">
												<small>Você tem</small>	
												<span><?= $balance; ?></span>
												<small><?= get_option('currecy_name'); ?></small>	
											</div>
										</button>
									</li>
									<li><a class="cart" href="<?= get_page_link(get_option('cart_page'));?>"><i class="fas fa-shopping-cart"></i></a></li>
									<li><a class="account" href="<?= get_page_link(get_option('profile_page'));?>"><i class="far fa-user"></i></a></li>
									<li><a class="contact" href="<?= get_page_link(get_option('contact_page'));?>"><i class="far fa-envelope"></i></a></li>
									<li>
										<button id="hamburger" aria-label="Menu" aria-controls="category-list" class="hamburger hamburger--spin" type="button">
											<span class="hamburger-box">
												<span class="hamburger-inner"></span>
											</span>
										</button>
									</li>
								</ul>
								</div>
								<a id="brand" href="<?php echo home_url() ?>">Brand</a>
                            </div>
                            <div class="col-12 order-md-last order-lg-0 col-lg-6">
                                <form id="fm-search-header" action="<?php echo get_permalink(esc_attr( get_option('search_page'))) ?>" method="GET" class="fm-search">
                                    <input value="<?php echo @$_GET['term'] ?>" id="search" type="text" name="term" placeholder="Busque na loja inteira por aqui..." maxlength="128" />
                                    <?php
									$query_string = $_SERVER['QUERY_STRING'];
									parse_str($query_string, $array);
									if (count($array) > 0) {
										foreach ($array as $k => $i) {
											if ($k != "term")
												echo "<input type='hidden' name='". $k ."' value='". $i ."' />";
										}
									}
									?>
									<button type="submit">Buscar</button>
                                </form>
                            </div>
                            <div class="col col-md-3 offset-md-6 offset-lg-0 d-none d-md-block">
									<?php
										$cart = ltm_getCart();
										$cart = json_decode($cart);
										
										if (isset($cart->items)) {
									?>									
									<a class="bx-header-cart" href="<?php echo get_permalink(esc_attr( get_option('cart_page'))) ?>">
										<strong>Carrinho</strong>
										<span class="cartInfos"><?php echo count($cart->items) ?> ite<?php echo count($cart->items) > 1 ? "ns" : "m" ?> 
										<br>
										 <?php echo $cart->price . " " . get_option("currecy_name") ?></span>
									</a>
									<?php 
										}
										?>
                            </div>
                        </div>
                    </div>
                </section>
			</header>

