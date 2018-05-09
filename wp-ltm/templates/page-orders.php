<?php
/**
 * Template Name: Pedidos
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
include get_template_directory() . '/inc/menu.php';


$order = ltm_order();



$order = $order['body'];
$order = json_decode($order);
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
			
			<?php
			if (isset($order)) {
			?>
			<table class="table datatable">
				<thead>
				<tr class="text-center">
					<th>
						Número
					</th>
					<th>
						Data
					</th>
					<th class="d-none d-md-table-cell">
						Frete
					</th>
					<th>
						Total
					</th>
					<th>
						#
					</th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($order as $e) {
				?>
				<tr class="text-center">
					<td>
						<small><?php echo $e->id ?></small>
					</td>
					<td>
						<small><?php
							$start = strtotime($e->date);
							echo $start = date('d/m/Y', $start);
						?></small>
					</td>
					<td class="d-none d-md-table-cell">
						<small><?php echo $e->shippingValuePoints ?></small>
					</td>
					<td>
						<small><?php echo $e->valuePoints ?></small>
					</td>
					<td>
						<a class='btn btn-secondary btn-sm' href="<?php echo get_order_url($e->id, $e->id); ?>">
							<img src="<?= get_template_directory_uri(); ?>/assets/img/eye.png" />
						</a>
					</td>
				</tr>
				<?php
				}
				?>
				</tbody>
			</table>
			<?php
			} else {
			?>	
				<p>Sem pedidos disponível.</p>
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

