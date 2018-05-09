<?php
/**
 * Template Name: Meu Endereço
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
include get_template_directory() . '/inc/menu.php';



$user = get_user_info($_COOKIE['ltm_islogged']);
$user = json_decode($user['body']);

$address = $user->address;
$user_id = $_COOKIE['wp_id'];
$naoexibir = 0;
if (get_user_meta($user_id, "street", true) != "") {
	$naoexibir = 1;
}
?>


<section id="profile">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
         	<?php include get_template_directory() . '/inc/categories.php'; ?>

			<?php if ( is_active_sidebar( 'profile_area' ) ) : ?>
				<?php dynamic_sidebar( 'profile_area' ); ?>
			<?php endif; ?>
        </div>

        <div class="col-12 col-md-9">
			<div class="row align-items-end clearfix my-3">
				<div class="col-12 align-text-bottom justify-content-center">
					<h1 class="my-0"><?php the_title(); ?></h1>
				</div>
			</div>
			<form method="POST">
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<h2>Endereço #1</h2>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<label class="col-form-label">Logradouro</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="street" value="<?php echo $address->street ?>">
						</div>
					</div>
					
				</div>
				<div class="form-row">
					<div class="col-md-3 mb-3">
						<label class="col-form-label">Número</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="number" value="<?php echo $address->number ?>">
						</div>
					</div>
					<div class="col-md-9 mb-3">
						<label class="col-form-label">Complemento</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="complement" value="<?php echo $address->complement ?>">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 mb-3">
						<label class="col-form-label">Cep</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="zipCode" value="<?php echo $address->zipCode ?>">
						</div>
					</div>
				</div>
				<div class="form-row">
					
					<div class="col-md-4 mb-3">
						<label class="col-form-label">Bairro</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="district" value="<?php echo $address->district ?>">
						</div>
					</div>
					<div class="col-md-4 mb-3">
						<label class="col-form-label">Cidade</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="city" value="<?php echo $address->city ?>">
						</div>
					</div>
					<div class="col-md-4 mb-3">
						<label class="col-form-label">Estado</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="state" value="<?php echo $address->state ?>">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<label class="col-form-label">Referência</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="reference" value="<?php echo $address->reference ?>">
						</div>
					</div>
				</div>
				<div class="form-row">
					<?php
					if ($naoexibir == 0) {
						?>
						<div class="col-6 text-left" >
							
							<button type="button" class="btn-buy btn btn-secondary rounded-0" data-toggle="modal" data-target="#inserir">Novo Endereço</button>			
						</div>
						<?php
					}
					?>
					<div class="<?php echo $naoexibir != 0 ? "offset-6" : "" ?> col-6 text-right" >
						<input type="hidden" name="task" value="address">
						<input type="hidden" name="item" value="1">
						<button type="submit" class="btn-buy rounded-0 btn btn-secondary">Salvar</button>				
					</div>
				</div>
			
			
			</form>
			
						
						<?php					
						
						if (get_user_meta($user_id, "street", true) != "") {
						?>
									<form method="POST" class="mt-4 pt-4 border-top">
										<div class="form-row">
											<div class="col-md-12 mb-3">
												<h2>Endereço #2</h2>
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-12 mb-3">
												<label class="col-form-label">Logradouro</label>
												<div class="col-sm-12 px-0">
													<input type="text" class="form-control rounded-0" name="street" value="<?php echo get_user_meta($user_id, "street", true) ?>">
												</div>
											</div>
											
										</div>
										<div class="form-row">
											<div class="col-md-3 mb-3">
												<label class="col-form-label">Número</label>
												<div class="col-sm-12 px-0">
													<input type="text" class="form-control rounded-0" name="number" value="<?php echo get_user_meta($user_id, "number", true) ?>">
												</div>
											</div>
											<div class="col-md-9 mb-3">
												<label class="col-form-label">Complemento</label>
												<div class="col-sm-12 px-0">
													<input type="text" class="form-control rounded-0" name="complement" value="<?php echo get_user_meta($user_id, "complement", true) ?>	">
												</div>
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-4 mb-3">
												<label class="col-form-label">Cep</label>
												<div class="col-sm-12 px-0">
													<input type="text" class="form-control rounded-0" name="zipCode" value="<?php echo get_user_meta($user_id, "zipcode", true) ?>">
												</div>
											</div>
										</div>
										<div class="form-row">
											
											<div class="col-md-4 mb-3">
												<label class="col-form-label">Bairro</label>
												<div class="col-sm-12 px-0">
													<input type="text" class="form-control rounded-0" name="district" value="<?php echo get_user_meta($user_id, "district", true) ?>">
												</div>
											</div>
											<div class="col-md-4 mb-3">
												<label class="col-form-label">Cidade</label>
												<div class="col-sm-12 px-0">
													<input type="text" class="form-control rounded-0" name="city" value="<?php echo get_user_meta($user_id, "city", true) ?>">
												</div>
											</div>
											<div class="col-md-4 mb-3">
												<label class="col-form-label">Estado</label>
												<div class="col-sm-12 px-0">
													<input type="text" class="form-control rounded-0" name="state" value="<?php echo get_user_meta($user_id, "state", true) ?>">
												</div>
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-12 mb-3">
												<label class="col-form-label">Referência</label>
												<div class="col-sm-12 px-0">
													<input type="text" class="form-control rounded-0" name="reference" value="<?php echo get_user_meta($user_id, "reference", true) ?>">
												</div>
											</div>
										</div>
										<div class="form-row">
											<div class="offset-6 col-6 text-right" >
												<input type="hidden" name="task" value="address">
												<input type="hidden" name="item" value="2">
												<button type="submit" class="btn-buy rounded-0 btn btn-secondary">Salvar</button>				
											</div>
										</div>
									
									
									</form>						
						<?php
						}
						?>
				
        </div>
    </div>
  </div>
</section>

<div class="modal fade" id="sucesso" tabindex="-1" role="dialog" aria-labelledby="SucessoTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	
	  <div class="modal-body text-center">
		
			<div class="row">
					<div class="col-12 display-4">
						<i class="fas fa-check"></i>
					</div>
					<div class="col-12 mt-4">
						<strong>Cadastro atualizado</strong> com sucessso.
					</div>
			</div>
	  </div>
	  <div class="modal-footer text-center">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	  </div>
	</div>
  </div>
</div>
<div class="modal fade" id="erro" tabindex="-1" role="dialog" aria-labelledby="erroTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	
	  <div class="modal-body text-center">
				<div class="row">
					<div class="col-12 display-4">
						<i class="fas fa-exclamation"></i>
					</div>
					<div class="col-12 mt-4">
						<strong>Não foi possível</strong> atualizar o cadastro.
					</div>
				</div>
	  </div>
	  <div class="modal-footer text-center">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	  </div>
	</div>
  </div>
</div>
<div class="modal fade" id="inserir" tabindex="-1" role="dialog" aria-labelledby="inserirTitle" aria-hidden="true">
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
							<div class="col-12 col-md-10">
								<div class="form-group">
									<label for="endereco">Endereço</label>
									<input type="text" class="form-control rounded-0" name="endereco"  id="endereco" placeholder="Endereço">
								</div>
							</div>
							<div class="col-12 col-md-2">
								<div class="form-group">
									<label for="numero">Número</label>
									<input type="text" class="form-control rounded-0" name="numero"id="numero" placeholder="Número">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-8">
								<div class="form-group">
									<label for="complemento">Complemento</label>
									<input type="text" class="form-control rounded-0" name="complemento" id="complemento" placeholder="Complemento">
								</div>
							</div>
							<div class="col-12 col-md-4">
								<div class="form-group">
									<label for="cep">CEP</label>
									<input type="text" class="form-control rounded-0" name="cep" id="cep" placeholder="CEP">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-12 col-md-4">
								<div class="form-group">
								<label for="bairro">Bairro</label>
								<input type="text" class="form-control rounded-0" name="bairro" id="bairro" placeholder="Bairro">
								</div>
							</div>
							<div class="col-8 col-md-4">
								<div class="form-group">
									<label for="cidade">Cidade</label>
									<input type="text" class="form-control rounded-0" name="cidade" id="cidade" placeholder="Cidade">
								</div>
							</div>
							<div class="col-4 col-md-4">
								<div class="form-group">
									<label for="UF">Estado</label>
									<input maxlength="2" type="text" class="form-control rounded-0" name="UF" id="UF" placeholder="UF">
								</div>
							</div>
							<div class="col-12 col-md-10">
								<div class="form-group">
									<label for="endereco">Ponto de referência</label>
									<input type="text" class="form-control rounded-0" name="reference"  id="reference" placeholder="Ponto de Referência">
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
<?php get_footer(); ?>
<?php
if (isset($_GET['r']) && ($_GET['r'] == 1 || $_GET['r'] == 2)) {
	?>
	<script>
		$("#<?php echo $_GET['r'] == 1 ? 'sucesso' : "erro" ?>").modal();
	</script>
	<?php
}
?>

