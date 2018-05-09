<?php
/**
 * Template Name: Checkout
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
while ( have_posts() ) : the_post(); ?>
	<?php 
		$postid = get_the_ID();

		$user = get_user_info($_COOKIE['ltm_islogged']);
		$user = json_decode($user['body']);
		
		$address = $user->address;
		
		$user_id = $_COOKIE['wp_id'];
		
		
		$cart = ltm_getCart();
		$cart = json_decode($cart);
	?>
	<div class="container">
		<section id="checkout" class="row">
			<div class="col-12">
				<div class="row align-items-end clearfix mt-5 mb-0">
					<div class="col-12 align-text-bottom justify-content-center">
						<h2><?php the_title(); ?></h3>
					</div>
				</div>
				<div class="row my-2">
					<div class="col-12 text-left">
						<?php the_content(); ?>
					</div>
				</div>
			</div>
			<div class="col-12">
				<div class="row">
			
				<form method="post" id="form-checkout">
					<div id="accordion" class="checkout col-12">
					
						<div class="panel checkout-step">
							<h3>Dados pessoais</h3>
							<div id="collapseInfos" class="in collapse show">
								<div class="col-12 py-3">
									<div class="row my-3">
										<div class="col-12 text-left">
											Confirme suas informações
										</div>
									</div>
									<div class="row clearfix my-0">
										<div class="col-12 my-0 py-0">
											<table class="table table-bordered">
												<tr>
													<td>
														<strong>Nome: </strong>
													</td>
													<td colspan="3">
														<?php echo $user->name ?>	
													</td>
												</tr>
												<tr>
													<td>
														<strong>E-mail: </strong>
													</td>
													<td>
														<?php 
															$emails = $user->emails;
															echo $emails[0]->email;
														?>
													</td>
													<td>
														<strong>Telefone: </strong>
													</td>
													<td>
														<?php 
														$phones = $user->phones;
														if (isset($phones[0])) {
															echo $phones[0]->areaCode . ' ' . $phones[0]->number;
														}
														?>
													</td>
												</tr>
												<tr>
													<td>
														<strong>Documento: </strong>
													</td>
													<td>
														<?php echo $user->documentNumber ?>
													</td>
													<td>
														<strong>Data de Nascimento: </strong>
													</td>
													<td>
														<?php echo date("d/m/Y", strtotime($user->birthDate)) ?>
													</td>
												</tr>
											</table>
										</div>
										<div class="col-12 text-right" >
											<a role="button" onclick="$('.collapse').collapse('hide');" data-toggle="collapse" data-parent="#accordion" href="#collapseAddress" class="btn-buy btn btn-secondary rounded-0">Prosseguir</a>				
										</div>
									</div>
								</div>	
							</div>	
						</div>
						<div class="panel checkout-step">
							<h3>Endereços para entrega</h3>
							<div id="collapseAddress" class="panel-collapse collapse">
								<div class="col-12 my-3 py-5">
									<div class="row clearfix my-0">
										<div class="col-12 my-0 py-0">
											<table class="table table-bordered">
												<tr>
													<td>
														<strong>Endereço: </strong>
													</td>
													<td colspan="5">
														<?php echo $address->street ?>	
													</td>
													<td>
														<?php echo $address->number ?>	
													</td>
													
												</tr>
												
												<tr>
													<td>
														<strong>Complemento: </strong>
													</td>
													<td colspan="4">
														<?php echo $address->complement ?>	
													</td>
													<td>
														<strong>CEP: </strong>
													</td>
													<td>
														<?php echo $address->zipCode ?>	
													</td>
												</tr>
												<tr>
													<td>
														<strong>Bairro: </strong>
													</td>
													<td>
														<?php echo $address->district ?>	
													</td>
													<td>
														<strong>Cidade: </strong>
													</td>
													<td>
														<?php echo $address->city ?>	
													</td>
													<td>
														<strong>UF: </strong>
													</td>
													<td>
														<?php echo $address->state ?>	
													</td>
													<td>
														<label class="custom-control material-switch">
															<span class="material-switch-control-description">&nbsp;</span>
															<input value="0" checked="true" name="endereco" type="radio" class="material-switch-control-input">
															<span class="material-switch-control-indicator"></span>
															<span class="material-switch-control-description">Selecionar</span>
														</label>
													</td>
												</tr>
												
												<?php					
												$naoexibir = 0;
												
												if (get_user_meta($user_id, "street", true) != "") {
												?>
												</table>
												<table class="table table-bordered">
												<tr class="table-light">
													<td>
														<strong>Endereço: </strong>
													</td>
													<td colspan="5">
														<?php echo get_user_meta($user_id, "street", true) ?>	
													</td>
													<td>
														<?php echo get_user_meta($user_id, "number", true) ?>	
													</td>
													
												</tr>
												
												<tr class="table-light">
													<td>
														<strong>Complemento: </strong>
													</td>
													<td colspan="4">
														<?php echo get_user_meta($user_id, "complement", true) ?>	
													</td>
													<td>
														<strong>CEP: </strong>
													</td>
													<td>
														<?php echo get_user_meta($user_id, "zipcode", true) ?>	
													</td>
												</tr>
												<tr class="table-light">
													<td>
														<strong>Bairro: </strong>
													</td>
													<td>
														<?php echo get_user_meta($user_id, "district", true) ?>	
													</td>
													<td>
														<strong>Cidade: </strong>
													</td>
													<td>
														<?php echo get_user_meta($user_id, "city", true) ?>	
													</td>
													<td>
														<strong>UF: </strong>
													</td>
													<td>
														<?php echo get_user_meta($user_id, "state", true) ?>	
													</td>
													<td>
														<label class="custom-control material-switch">
															<span class="material-switch-control-description">&nbsp;</span>
															<input value="0" checked="true" name="endereco" type="radio" class="material-switch-control-input">
															<span class="material-switch-control-indicator"></span>
															<span class="material-switch-control-description">Selecionar</span>
														</label>
														<!--<table class="table border-0 my-0">
															
															<tr  class="table-light">
																<td class="border-0">&nbsp;</td>
															</tr>
															<tr class="table-light">
																<td class="border-0 text-center">
																	<label class="custom-control material-switch">
																		<span class="material-switch-control-description">&nbsp;</span>
																		<input value="1" name="endereco" type="radio" class="material-switch-control-input">
																		<span class="material-switch-control-indicator"></span>
																		<span class="material-switch-control-description">Selecionar</span>
																	</label>
																</td>
															</tr>
															<tr class="table-light">
																<td class="border-0">&nbsp;</td>
															</tr>
														</table>-->
														
														
													</td>
												</tr>
												</table>
												<table class="table table-bordered">
												<?php
													$naoexibir = 1;
												}
												if ($naoexibir == 0) {
												?>
												<tr>
													<td colspan="6">
														
													</td>
													<td class="text-center">
														<button type="button" class="btn-buy btn btn-secondary rounded-0" data-toggle="modal" data-target="#novoEndereco">Novo Endereço</button>
													</td>
												</tr>
												<?php
												}
												?>
											</table>
										</div>

										<div class="col-12 border-bottom" >
											<div class="row align-items-end clearfix my-5">
												<div class="col-6 text-left align-text-bottom" >
													<a role="button" onclick="$('.collapse').collapse('hide');" data-toggle="collapse" data-parent="#accordion" href="#collapseInfos" class="btn btn-light float-md-left rounded-0">Voltar</a>				
												</div>
												<div class="col-6 text-right align-text-bottom" >
													<a role="button" onclick="$('.collapse').collapse('hide');" data-toggle="collapse" data-parent="#accordion" href="#collapseCheckout" class="btn-buy btn btn-secondary float-md-right rounded-0 step-shipping">Prosseguir</a>
												</div>
											</div>
										</div>
										
										
									</div>
								</div>	
						</div>	
					</div>	
						<div class="panel checkout-step">
							<h3>Resumo do Pedido</h3>
							<div id="collapseCheckout" class="panel-collapse collapse">
								<div class="col-12 my-3 py-5">
									<div class="row clearfix my-0">
										<div class="text-center loading w-100 position-absolute d-none align-items-center justify-content-center">
											<img src="<?php echo get_template_directory_uri() ?>/assets/img/loading.gif" class="w-25" />
										</div>
										<table class="table table-bordered">
												<tr  class="table-light d-none d-md-table-row">
													<td scope="col" class=" text-center">
														Imagem
														</td>
													<td scope="col" class="  text-left">
														Produto
														</td>
													<td scope="col" class=" text-center">
														Quantidade
														</td>
													<td scope="col" class=" text-center">
														Valor Unitário
													</td>
													<td scope="col" class=" text-center">
														Valor Total
													</td>
												</tr>
												<tr  class="table-light d-table-row d-md-none">
													<td scope="col" colspan="5" class=" text-center">
														Produtos
													</td>
												</tr>
												<?php
												$itens = $cart->items;
												
												$totalQuantity =0;
												$totalValue =0;
												foreach ($itens as $item) {
													
													$totalQuantity += $item->quantity;
													$totalValue += ($item->quantity * $item->price);
												?>
												<tr class="cart-item">
													<td class="text-center">
														<img class="img-fluid w-25" src='<?php echo $item->imageUrl ?>' />
													</td>
													<td class="cart-name text-left">
														<p class="mb-1">
															<?php echo $item->name ?>
														</p>
														<p class="mb-1">
															<?php echo isset($item->category->name) ? $item->category->name : "" ?>
														</p>
													</td>
													<td class="cart-quantity text-center align-items-center">
														<div class="form-group">
															<?php echo $item->quantity ?>
														</div>
													</td>
													<td class="cart-price text-center">
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
													
												</tr>
												<?php
												}
												?>
												<tr class="d-none d-md-table-row">
													<td colspan="3">
														&nbsp;
													</td>
													<td>
														<strong>Frete</strong>
													</td>
													<td class="tax text-center">
														&nbsp;
													</td>
												</tr>
												<tr class="d-none d-md-table-row">
													<td colspan="3">
														&nbsp;
													</td>
													<td>
														<strong>Total</strong>
													</td>
													<td class="total text-center">
														&nbsp;
													</td>
												</tr>
										</table>
										
										
										<div class="col-12  border-bottom" >
											<div class="row align-items-end clearfix my-5">
												<div class="text-left col-6 align-text-bottom" >
													<a role="button" onclick="$('.collapse').collapse('hide');" data-toggle="collapse" data-parent="#accordion" href="#collapseAddress" class="btn btn-light  rounded-0">Voltar</a>
												</div>
												<div class="text-right col-6 align-text-bottom" >
													<input type="hidden" name="action" value="checkout">
													<button type="submit" class="btn-checkout btn-buy btn btn-secondary rounded-0">Concluir</button>
												</div>
											</div>
										</div>
									</div>
								</div>	
							</div>	
						</div>	
					</div>	
				</form>
			</div>
		</div>
			<!-- Modal -->
			<div class="modal fade" id="novoEndereco" tabindex="-1" role="dialog" aria-labelledby="novoEnderecoTitle" aria-hidden="true">
			  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
				<form method="post">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Novo endereço</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
						<div class="row">
							<div class="col-12">
									<div class="row">
										<div class="col-10">
											<div class="form-group">
												<label for="endereco">Endereço</label>
												<input type="text" class="form-control rounded-0" name="endereco"  id="endereco" placeholder="Endereço">
											</div>
										</div>
										<div class="col-2">
											<div class="form-group">
												<label for="numero">Número</label>
												<input type="text" class="form-control rounded-0" name="numero"id="numero" placeholder="Número">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-8">
											<div class="form-group">
												<label for="complemento">Complemento</label>
												<input type="text" class="form-control rounded-0" name="complemento" id="complemento" placeholder="Complemento">
											</div>
										</div>
										<div class="col-4">
											<div class="form-group">
												<label for="cep">CEP</label>
												<input type="text" class="form-control rounded-0" name="cep" id="cep" placeholder="CEP">
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-4">
											<div class="form-group">
											<label for="bairro">Bairro</label>
											<input type="text" class="form-control rounded-0" name="bairro" id="bairro" placeholder="Bairro">
											</div>
										</div>
										<div class="col-4">
											<div class="form-group">
												<label for="cidade">Cidade</label>
												<input type="text" class="form-control rounded-0" name="cidade" id="cidade" placeholder="Cidade">
											</div>
										</div>
										<div class="col-4">
											<div class="form-group">
												<label for="UF">Estado</label>
												<input maxlength="2" type="text" class="form-control rounded-0" name="UF" id="UF" placeholder="UF">
											</div>
										</div>
									</div>
							</div>
						</div>
				  </div>
				  <div class="modal-footer">
					<input type="hidden" name="action" value="novo-endereco">
					<button type="submit" class="btn-buy btn btn-secondary float-md-right rounded-0">Cadastrar novo endereço</button>
				  </div>
				</form>
				</div>
			  </div>
			</div>
			
			
			<div class="modal fade retorno-erro-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
			  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-body">
						<div class="row">
							<div class="col-12">
								<strong>Não foi possível</strong> concluir a compra, tente novamente.
							</div>
						</div>
				  </div>
				</div>
			  </div>
			</div>
		</section>
	</div>
<?php
endwhile;
get_footer('cart');
?>