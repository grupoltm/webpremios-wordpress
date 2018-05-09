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

if (isset($_GET['tracking'])) {
	$tracking = trim(addslashes($_GET['tracking']));
} else {
	exit();
}

$tracking = ltm_tracking($tracking);

$response = $tracking['response']['code'];

$tracking = $tracking['body'];
$tracking = json_decode($tracking);
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
			if ($response == 200) {
			?>
			<table class="table">
				<thead>
				<tr class="text-center">
					<th>
						Data
					</th>
					<th>
						Status
					</th>
				</tr>
				</thead>
				<tbody>
				<?php
				foreach ($tracking as $track) {
					$statuses = $track->statuses;
					foreach ($statuses as $e) {
					?>
					<tr class="text-center">
						<td>
							<small><?php
								$start = strtotime($e->when);
								echo $start = date('d/m/Y', $start);
							?></small>
						</td>
						<td>
							<small><?php echo $e->name ?></small>
						</td>
						
					</tr>
					<?php
					}
				}
				?>
				</tbody>
			</table>
			<div class="col-12 text-center my-4">
				<a class='btn btn-secondary btn-lg' href="<?php echo get_order_url($_GET['order'], $_GET['order']); ?>">
					Voltar
				</a>
			</div>
			<?php
			} else {
			?>	
				<p>Não existe rastreamento para este pedido;</p>
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

