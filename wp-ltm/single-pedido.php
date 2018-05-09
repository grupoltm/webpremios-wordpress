<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */

get_header(); 

include dirname(__FILE__) . '/inc/menu.php';

?>

<section>
  <div class="container">
    <div class="row">

        <div class="col-12 col-md-3">
			<?php include get_template_directory() . '/inc/categories.php'; ?>

			<?php if ( is_active_sidebar( 'profile_area' ) ) : ?>
				<?php dynamic_sidebar( 'profile_area' ); ?>
			<?php endif; ?>
        </div>

        <div class="col-12 col-md-9">
			
			
			<?php 
				if (have_posts()){
					while (have_posts()) {
						the_post();
						if (isset($_GET['pedido'])) {
							$pedido = $_GET['pedido'];
						} else {
							$pedido =  get_post_meta( get_the_ID(), "pedido", true );
							
						}
						
						
						$order = ltm_order();



						$order = $order['body'];
						$order = json_decode($order);
						$pedidoInfo = "";
						foreach ($order as $o) {
							
							if ($o->id == $pedido) {
								$pedidoInfo = $o;
								break;
							}
							
						}
					
						
						
						/*
						$url = urlbase_ltm .'/purchases/' . $pedido;
							
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
						$purchases = wp_remote_post( $url, $args);
						*/
						
						//echo "<pre>",print_r($pedidoInfo),"</pre>";
						?>
							<div class="row align-items-end clearfix my-3 mx-0 px-0">
								<div class="col-12 align-text-bottom justify-content-center">
									<h3 class="my-0">Sua Compra: #<?php the_title(); ?></h3>
									<p>
										<small>
											<strong>Data:</strong> <?php
											$start = strtotime($pedidoInfo->date);
											echo $start = date('d/m/Y', $start);
											?>
										</small>
									</p>
									
										<?php
										$customer = $pedidoInfo->customer;
										//echo "<pre>",print_r($customer),"<	/pre>";
										?>
									<div class="row">
										<div class="col-12">
											<table class="table table-bordered">
												<tr>
													<td class="d-block d-md-table-cell"><strong>Nome</strong></td>
													<td class="d-block d-md-table-cell" colspan="3">
														<?php echo $customer->name ?>
													</td>
												</tr>
												<tr>
													<td class="d-block d-md-table-cell"><strong>CPF</strong></td>
													<td class="d-block d-md-table-cell">
														<?php echo $customer->documentNumber ?>
													</td>
													<td class="d-block d-md-table-cell">
														<strong>Email:</strong>
													</td>
													<td class="d-block d-md-table-cell">
														<?php echo $customer->email ?>
													</td>
												</tr>
											</table>
										</div>
									</div>
									<h3 class="my-3">Seus pedidos</h3>
									<?php
									
									if (isset($pedidoInfo->orders)) {
									$orders = $pedidoInfo->orders;
									foreach ($orders as $o) {
											$items = $o->items;
									?>
										<div class='row py-4  px-0 mx-0'>
											<div class="col-12 col-md-3 mb-2">
												Pedido: #<?php echo $o->id ?>
											</div>
											<div class="col-12 col-md-5 mb-2">
												<small>Status: <strong><?php echo get_order_status($o->status) ?></strong></small>
											</div>
											<div class="col-12 col-md-4 text-md-right text-left  mb-2">
												<a href="<?php echo get_permalink(esc_attr( get_option('tracking_page'))) ?>?order=<?php echo $pedido ?>&tracking=<?php echo $o->id ?>" class="btn btn-primary">Acompanhar Pedido</a>
											</div>
											
											<div class="col-12 border px-2 mt-4">
												<?php
													foreach ($items as $item) {
													?>
													<div class="row">
														<div class='col-1 text-center border-right d-none d-md-inline-block'>
															<small><strong>Imagem</strong></small>
														</div>
														<div class='col-7 col-md-9 text-center border-right'>
															<small><strong>Nome</strong></small>
														</div>
														<div class='col-2 col-md-1 text-center border-right'>
															<small><strong>Qtd</strong></small>
														</div>
														<div class='col-3 col-md-1 text-center'>
															<small><strong>Pontos</strong></small>
														</div>
														<div class='col-1 pt-2 text-center border-right d-none d-md-inline-block'>
															<img src="<?php echo $item->imageUrl ?>" class="img-fluid" />
														</div>
														<div class='col-7 col-md-9 pt-2 text-center border-right'>
															<?php echo $item->name ?> (<?php echo $item->sku ?>)
														</div>
														<div class='col-2 col-md-1 pt-2 text-center border-right'>
															<?php echo $item->quantity ?>
														</div>
														<div class='col-3 col-md-1 pt-2 text-center'>
															<?php echo $item->valuePoints ?>
														</div>
													</div>
													<?php
													}
												?>
											</div>
										</div>
									<?php
									}
									} else {
										?>	
											<p>Sem pedidos disponível.</p>
										<?php
									}
									?>
									
								</div>
								<div class="col-12 my-4 text-center">
									<a class='btn btn-secondary btn-lg' href="<?php echo get_permalink(esc_attr( get_option('orders_page'))) ?>">
										Voltar
									</a>
								</div>
							</div>
							
						<?php
					}
				}					
			?>

        </div>

    </div>
  </div>
</section>
<?php get_footer(); ?>
