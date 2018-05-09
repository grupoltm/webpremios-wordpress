<?php

get_header(); 

include dirname(__FILE__) . '/inc/menu.php';

?>

<section>
  <div class="container">
    <div class="row">

        <div class="col-12 col-md-3">
          <?php include dirname(__FILE__) . '/inc/categories.php'; ?>
        </div>

        <div class="col-12 col-md-9">
		
			<?php 
				if (have_posts()){
					while (have_posts()) {
						the_post();
			?>
							
			<div id="product-details">
				<div class="row">
						<div class="col-12">
									<h1 class="my-3 clearfix"><?php the_title(); ?></h1>
									<div class="col-12"><?php the_content(); ?></div>
						</div>
				</div>
			</div>
		<?php 
							
					}
				}
		?>
        </div>

    </div>
  </div>
</section>
<?php get_footer(); ?>
