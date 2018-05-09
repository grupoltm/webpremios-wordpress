<?php
/**
 * The main template file
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */

get_header(); 

include dirname(__FILE__) . '/inc/menu.php';
?>


<section>
  <div class="container">
    <div class="row bx-cats">

        <div class="col-12 col-md-4 col-lg-3">
          <?php include dirname(__FILE__) . '/inc/categories.php'; ?>
        </div>

        <div class="col-12 col-md-8 col-lg-9 px-0">
          <?php if ( is_active_sidebar( 'slider_area' ) ) : ?>
            <?php dynamic_sidebar( 'slider_area' ); ?>
          <?php endif; ?>
		  
			<?php 
				$showcase = ltm_getShowcase();
				$showcase = json_decode( $showcase['body'] );
				
				if (isset($showcase->products)) {
					$products = $showcase->products;
					include dirname(__FILE__) . '/inc/showcase.php';
				} else {
					?>
					<div class="alert alert-danger my-3">
					  <?php echo $showcase->message ?>
					</div>
					<?php
				}
			?>
        </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
