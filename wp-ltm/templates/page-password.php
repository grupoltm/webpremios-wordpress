<?php
/**
 * Template Name: Alterar Senha
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
include get_template_directory() . '/inc/menu.php';



$user = get_user_info($_COOKIE['ltm_islogged']);
$user = json_decode($user['body']);

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
			<form name="resetPassword" class="resetPassword" method="POST">
				
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label class="col-form-label">Senha atual</label>
						<div class="col-sm-12 px-0">
							<input required="true"  type="password" placeholder="Senha Atual" class="form-control rounded-0 required"  name="oldPassword">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label class="col-form-label">Nova senha</label>
						<div class="col-sm-12 px-0">
							<input required="true" type="password" placeholder="Nova senha" class="form-control rounded-0 newPassword required"  name="newPassword">
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<label class="col-form-label">Repita sua nova senha</label>
						<div class="col-sm-12 px-0">
							<input required="true" type="password" placeholder="Repita sua nova senha" class="form-control rounded-0 repeatNewPassword required"  name="repeatNewPassword">
						</div>
					</div>

				</div>
					
					<div class="col-12 text-center" >
						<input type="hidden" name="task" value="password">
						<button type="submit" class="btn-buy rounded-0 btn btn-lg btn-secondary">Salvar</button>				
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
						<strong>Senha atualziada</strong> com sucessso.
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
						<strong>Não foi possível</strong> atualizar a senha.
					</div>
				</div>
	  </div>
	  <div class="modal-footer text-center">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	  </div>
	</div>
  </div>
</div>

<div class="modal fade" id="repeat" tabindex="-1" role="dialog" aria-labelledby="repeatTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	
	  <div class="modal-body text-center">
				<div class="row">
					<div class="col-12 display-4">
						<i class="fas fa-exclamation"></i>
					</div>
					<div class="col-12 mt-4">
						O campo <strong>Nova senha</strong> e <strong>Repita Nova senha</strong> estão diferentes.
					</div>
				</div>
	  </div>
	  <div class="modal-footer text-center">
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
	  </div>
	</div>
  </div>
</div>
<div class="modal fade" id="passwordEmpty" tabindex="-1" role="dialog" aria-labelledby="repeatTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
	<div class="modal-content">
	
	  <div class="modal-body text-center">
				<div class="row">
					<div class="col-12 display-4">
						<i class="fas fa-exclamation"></i>
					</div>
					<div class="col-12 mt-4">
						Por favor <strong>preencha</strong> os campos.
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
<script>
$(".resetPassword").on("submit", function(){
	$(".required").each(function(a,b){
		if ($(b).val() == "") {
			$("#passwordEmpty").modal();
			return false;
		}
	})
	if ($(".newPassword").val() != $(".repeatNewPassword").val()) {
		$("#repeat").modal();
		return false;
	}
})
<?php
if (isset($_GET['r']) && ($_GET['r'] == 1 || $_GET['r'] == 2)) {
?>
	$("#<?php echo $_GET['r'] == 1 ? 'sucesso' : "erro" ?>").modal();
<?php
}
?>
</script>