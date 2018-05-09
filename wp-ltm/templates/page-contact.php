<?php
/**
 * Template Name: Contato
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
include get_template_directory() . '/inc/menu.php';
?>


<section id="profile">
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
         	<?php include get_template_directory() . '/inc/categories.php'; ?>

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
						<label class="col-form-label">Nome</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="name" placeholder="Seu Nome" value="">
						</div>
					</div>
					
				</div>
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<label class="col-form-label">E-mail</label>
						<div class="col-sm-12 px-0">
							<input type="email" class="form-control rounded-0" name="email" placeholder="Seu E-mail" value="">
						</div>
					</div>
					
				</div>
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<label class="col-form-label">Assunto</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="subject" placeholder="Qual o assunto?" value="">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-12 mb-3">
						<label class="col-form-label">Mensagem</label>
						<div class="col-sm-12 px-0">
							<textarea rows="6" class="form-control rounded-0" name="message" placeholder="Sua mensagem"></textarea>
						</div>
					</div>
				</div>
				
				<div class="form-row">
					<div class="offset-6 col-6 text-right" >
						<input type="hidden" name="task" value="contact">
						<input type="hidden" name="item" value="1">
						<button type="submit" class="btn-buy rounded-0 btn btn-secondary">Salvar</button>				
					</div>
				</div>
			
			
			</form>
			
						
						
				
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
						<strong>Mensagem enviada</strong> com sucessso.
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
						<strong>Não foi possível</strong> enviar sua mensagem.
					</div>
				</div>
	  </div>
	  <div class="modal-footer text-center">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	  </div>
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

