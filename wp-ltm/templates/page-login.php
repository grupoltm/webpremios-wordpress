<?php
/**
 * Template Name: Login
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
 get_header('ltm-login');

?>
<section id="login" class="row px-0 mx-0 justify-content-md-center">
	<div class="col-12 px-3 col-md-4 align-self-center">
			<div class="row justify-content-md-center">
				<a id="brand" href="#">Brand</a>
			</div>
			<form class="form-horizontal" role="form" method="POST">
				<?php
				if( !empty($GLOBALS['err']) ) {
					?>
						<div class="alert alert-warning" role="alert">
							<?php echo $GLOBALS['err'] ?>
						</div>
					<?php
				}
				?>
				<?php
				if( !empty($GLOBALS['succ']) ) {
					?>
						<div class="alert alert-success" role="alert">
							<?php echo $GLOBALS['succ'] ?>
						</div>
					<?php
				}
				?>
				<div class="form-group">
					<label class="sr-only" for="usuario">Usuário</label>
					<div class="input-group">
						<input type="text" name="usuario" class="form-control" id="usuario"
							   placeholder="Usuário" required>
					</div>
				</div>
				<div class="form-group">
					<label class="sr-only" for="senha">Senha</label>
					<div class="input-group">
						<input type="password" name="senha" class="form-control" id="senhaS"
							   placeholder="Senha" required>
					</div>
				</div>
				<div class="justify-content-md-center">
					<div class="">
						<button type="submit">Entrar</button>
						<input type="hidden" name="task" value="login" />
					</div>
				</div>
				<div class="login-help text-center">
					<a href="<?php echo get_permalink(esc_attr( get_option('reset_page'))) ?>">Esqueci minha senha</a>
				</div>
			</form>			
	</div>	
</section>
<?php
 get_footer('ltm-login');
?>