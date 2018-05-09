<?php
/**
 * Template Name: Meus Dados
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
			<form method="POST">
				<div class="form-row">
					<!--<div class="col-md-4 mb-3">
						<label class="col-form-label">Usuário</label>
						<div class="col-sm-12 px-0">
							<input type="text" readonly class="form-control rounded-0" name="username" value="<?php echo $user->username ?>">
						</div>
					</div>-->
					<div class="col-md-12 mb-3">
						<label class="col-form-label">Nome</label>
						<div class="col-sm-12 px-0">
							<input type="text" readonly class="form-control rounded-0" name="name" value="<?php echo $user->name ?>">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-4 mb-3">
						<label class="col-form-label">CPF</label>
						<div class="col-sm-12 px-0">
							<input type="text" readonly class="form-control rounded-0"  name="documentNumber" value="<?php echo $user->documentNumber ?>">
						</div>
					</div>
					<div class="col-md-4 mb-3">
						<label class="col-form-label">RG</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0" name="rg" value="<?php echo $user->rg ?>">
						</div>
					</div>
					<div class="col-md-4 mb-3">
						<label class="col-form-label">Nascimento</label>
						<div class="col-sm-12 px-0">
							<input type="text" class="form-control rounded-0 maskDate" name="birthDate" value="<?php echo date("d/m/Y", strtotime($user->birthDate)) ?>">
						</div>
					</div>
				</div>
				<div class="form-row">
					<div class="col-md-6 mb-3">
						<label class="col-form-label">Gênero</label>
						<div class="col-sm-12 px-0">
								<select name="genderType" class="form-control rounded-0">
									<option <?php echo $user->genderType == "FEMALE" ? 'checked="true"' : "" ?> value="FEMALE">Feminino</option>
									<option <?php echo $user->genderType == "MALE" ? 'checked="true"' : "" ?>  value="MALE">Masculino</option>
									<option <?php echo $user->genderType == "UNINFORMED" ? 'checked="true"' : "" ?>  value="UNINFORMED">Não Informado</option>
								</select>
						</div>
					</div>
					<div class="col-md-6 mb-3">
						<label class="col-form-label">Estado Civil</label>
						<div class="col-sm-12 px-0">
							<select name="maritalStatus" class="form-control rounded-0">
								<option <?php echo $user->maritalStatus == "MARRIED" ? 'checked="true"' : "" ?> value="MARRIED">Casado(a)</option>
								<option <?php echo $user->maritalStatus == "DIVORCED" ? 'checked="true"' : "" ?>  value="DIVORCED">Divorciado(a)</option>
								<option <?php echo $user->maritalStatus == "UNINFORMED" ? 'checked="true"' : "" ?>  value="UNINFORMED">Não Informado</option>
								<option <?php echo $user->maritalStatus == "SEPARATED" ? 'checked="true"' : "" ?>  value="SEPARATED">Separado(a)</option>
								<option <?php echo $user->maritalStatus == "SINGLE" ? 'checked="true"' : "" ?>  value="SINGLE">Solteiro(a)</option>
								<option <?php echo $user->maritalStatus == "WIDOWED" ? 'checked="true"' : "" ?>  value="WIDOWED">Viúvo(a)</option>
							</select>
						</div>
					</div>
					<div class="col-12 text-center" >
						<input type="hidden" name="task" value="profile">
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

