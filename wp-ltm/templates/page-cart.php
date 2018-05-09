<?php
/**
 * Template Name: Cart
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
while ( have_posts() ) : the_post(); ?>
	<?php 
	$cart = ltm_getCart();
	$cart = json_decode($cart);
	$itens = $cart->items;
				
	?>
	<div class="container">
		<section id="cart" class="row mx-0 px-0">
			<form class="col-12 px-0" action="<?php echo get_permalink(esc_attr( get_option('checkout_page'))) ?>" method="post">
					<div class="row align-items-end clearfix my-3">
						<div class="col-12 align-text-bottom justify-content-center">
							<h1 class="my-0 text-center text-md-left"><?php the_title(); ?></h1>
						</div>
					</div>
					<div class="row my-3">
						<div class="col-12 text-center">
							<?php the_content(); ?>
						</div>
					</div>
					<div class="row align-items-end clearfix my-3">
						<div class="col-3 d-none d-md-block align-text-bottom" >
							<a href="<?php echo get_site_url() ?>" class="rounded-0 btn btn btn-light">Continuar Comprando</a>				
						</div>
						<?php
						if (count($itens) > 0) {
							?>
							<div class="offset-md-6 offset-0 col-12 col-md-3 text-right align-text-bottom" >
								<button type="submit" class="btn-buy rounded-0 btn btn-lg btn-secondary">Comprar</button>				
							</div>
							<?php
						}
						?>
					</div>
					
				<div class="my-3 border-top border-bottom py-5">
					<table class="table table-bordered">
						<thead>
							<tr  class="table-light">
								<th scope="col" class=" text-center">
									Imagem
								</th>
								<th scope="col" class="text-md-left text-center">
									Produto
								</th>
								<th scope="col" class=" text-center">
									Quantidade
								</th>
								<th scope="col" class=" text-center">
									Valor Unitário
								</th>
								<th scope="col" class=" text-center">
									Valor Total
								</th>
								<th scope="col" class=" text-center">
									#
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							
							$totalQuantity =0;
							$totalValue =0;
							
							if (count($itens) > 0) {
								foreach ($itens as $item) {
									
									$totalQuantity += $item->quantity;
									$totalValue += ($item->quantity * $item->price);
								?>
								<tr class="cart-item">
									<td class="text-center" width="100">
										<img class="img-fluid" src='<?php echo $item->imageUrl ?>' />
									</td>
									<td class="cart-name text-left w-50">
										<p class="mb-1">
											<?php echo $item->name ?>
										</p>
										<strong>
											<?php echo isset($item->category->name) ? $item->category->name : "" ?>
										</strong>
										<input type="hidden" class="vendorId" data-value="<?php echo $item->vendor->id ?>" />
										<input type="hidden" class="sku" data-value="<?php echo $item->sku ?>" />
										<!--<p class="mb-1">
											<span class="badge badge-success availability">
												Disponível
											</span>
										</p>-->
									</td>
									<td class="cart-quantity text-center align-items-center">
										<div class="form-group">
											<input class="quantity form-control text-center rounded-0" value="<?php echo $item->quantity ?>"  maxlength="2" type="number" name="quantity" min="1" max="99">
										</div>
									</td>
									<td class="cart-price text-center" data-value="<?php echo $item->price ?>">
										<?php
											if ($item->regularPrice < $item->price) {
												echo "<s class='d-block'>" . $item->regularPrice . "</s>";
											}
											echo "<span>" . number_format($item->price, 2, ',', '.') . "</span>";
										?>
									</td>
									<td class="cart-total text-center" data-value="<?php echo $item->price * $item->quantity ?>">
										<?php
											echo number_format($item->price * $item->quantity, 2, ',', '.');
										?>
									</td>
									<td class="cart-action text-center">
										<span class="badge badge-danger rounded-0 btn-delete-item">
											X
										</span>
									</td>
								</tr>
								<?php
								}
							} else {
								?>
									<tr>
										<td class="text-center" colspan="6">
											Seu carrinho está vazio!
										</td>										
									</tr>
								<?php
							}
							?>
						</tbody>
					</table>
				</div>	
				<div class="row">
			
					<div class="col-12 col-md-7">
						<strong class="small-title">Simule o prazo de entrega e o frete para seu CEP abaixo:</strong>
						
						<div class="row row-eq-height align-items-center">
							<div class="col-8 col-md-5 justify-content-center">
								<div class="form-group">
									<input class="inputTax form-control rounded-0" type="text">
								</div>
							</div>
							<div class="col-4 col-md-2 justify-content-center">
								<div class="form-group">
									<button type="button" class="getTax btn btn-lg btn-secondary rounded-0">OK</button>
								</div>
							</div>
							<div class="col-12 col-md-5 justify-content-center">
								<div class="form-group text-md-left text-center">
									<a href="#">Não sei meu CEP</a>
								</div>
							</div>
						</div>
						<small>
							<b>Atenção:</b> 
							O prazo começa a contar a partir da aprovação do pagamento.<br />
							Os produtos podem ser entregues separadamente.
						</small>
					</div>
					<div class="col-12 col-md-5 cartInfos position-relative">
						<div class="text-center loading w-100 position-absolute d-none align-items-center justify-content-center">
							<img src="<?php echo get_template_directory_uri() ?>/assets/img/loading.gif" class="w-25" />
						</div>
						<table class="totalCart table table-sm">
							<tr>
								<td>
									Total de Produtos
								</td>
								<th class="totalQuantity text-right" data-total="<?php echo $totalQuantity ?>">
									<?php echo $totalQuantity ?>
								</th>
							</tr>
							<tr>
								<td>
									Valor
								</td>
								<th class="totalValue text-right" data-total="<?php echo $totalValue ?>">
									<?php echo number_format($totalValue, 2, ',', '.'); ?>
								</th>
							</tr>
							<tr>
								<td>
									Frete
								</td>
								<th class="totalTax text-right" data-total="0">
									-
								</th>
							</tr>
							<tr>
								<td>
									Total
								</td>
								<th class="cartTotal text-right" data-total="<?php echo $totalValue ?>">
									<?php echo number_format($totalValue, 2, ',', '.'); ?>
								</th>
							</tr>
						</table>
					</div>
				</div>				

					<div class="row align-items-end clearfix my-3">
						<div class="col-3 d-none d-md-block align-text-bottom" >
							<a href="<?php echo get_site_url() ?>" class="rounded-0 btn btn btn-light">Continuar Comprando</a>				
						</div>
						<?php
						if (count($itens) > 0) {
							?>
							<div class="offset-md-6 offset-0 col-12 col-md-3 text-right align-text-bottom" >
								<button type="submit" class="btn-buy rounded-0 btn btn-lg btn-secondary">Comprar</button>				
							</div>
							<?php
						}
						?>
					</div>
			</form>
		</section>
	</div>
<?php
endwhile;
get_footer('cart');
?>