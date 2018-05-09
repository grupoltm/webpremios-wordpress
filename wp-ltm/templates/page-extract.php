<?php
/**
 * Template Name: Extrato
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
include get_template_directory() . '/inc/menu.php';


if (isset($_GET['t'])){
	$start = strtotime("-". $_GET['t'] ." month" . ($_GET['t'] > 0 ? "s" : ""));
	
	$end = date('t/m/Y', $start);
	$start = date('01/m/Y', $start);

} else {
	$start = strtotime("-0 month");
	
	$end = date('t/m/Y', $start);
	$start = date('01/m/Y', $start);

}


$extract = ltm_extract($start, $end);
$extract = $extract['body'];
$extract = json_decode($extract);


?>


<section id="extract">
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
				<div class="col-12">
					<p>
						<small class="border-right pr-3 mr-3 d-block d-md-inline">Período: <?php echo $start ?> a <?php echo $end ?></small>
						<a  class="btn bt-sm btn-light" href="<?php echo get_permalink( get_option("extract_page")) ?>?t=0"><small>Mês Atual</small></a>
						<a  class="btn bt-sm btn-light"  href="<?php echo get_permalink( get_option("extract_page")) ?>?t=1"><small>Último Mês</small></a>
						<a  class="btn bt-sm btn-light"  href="<?php echo get_permalink( get_option("extract_page")) ?>?t=2"><small>Penúltimo Mês</small></a>
					</p>
				</div>
			</div>
			<?php
			if (isset($extract)) {
			?>
			<div class="w-100 overflow-x">
				<table class="table datatable">
					<thead>
					<tr class="text-center">
						<th class="d-none d-md-table-cell">
							Código
						</th>
						<th>
							Data
						</th>
						<th>
							Descrição
						</th>
						<th>
							Total <span class="d-md-inline-block d-none">de Pontos</span>
						</th>
						<th>
							Tipo
						</th>
					</tr>
					</thead>
					<tbody>
					<?php
					foreach ($extract as $e) {
					?>
					<tr class="text-center">
						<td class="d-none d-md-table-cell">
							<small>
								<?php 
									echo $e->authorizationCode;
								?>
							</small>
						</td>
						<td>
							<small>
								<?php 
									echo date("d/m/Y", strtotime($e->date));
								?>
							</small>
						</td>
						<td>
							<small>
								<?php 
									echo $e->description;
								?>
							</small>
						</td>
						<td>
							<small>
								<?php 
									echo $e->valuePoints;
								?>
							</small>
						</td>
						<td>
							<small>
								<?php 
									echo $e->type == 'DEBIT' ? "Débito" : "Crédito";
								?>
							</small>
						</td>
					</tr>
					<?php
					}
					?>
					</tbody>
				</table>
			</div>
			<?php
			} else {
			?>	
				<p>Sem extrato disponível.</p>
			<?php
			}			
			?>
        </div>
    </div>
  </div>
</section>

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

