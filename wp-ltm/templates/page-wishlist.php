<?php
/**
 * Template Name: Lista de Desejo
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
include get_template_directory() . '/inc/menu.php';


$products = ltm_getWishlist();

$retorno = $products['response']['code'];

?>


<section>
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
          <?php include get_template_directory() . '/inc/categories.php'; ?>
          <?php if ( is_active_sidebar( 'profile_area' ) ) : ?>
            <?php dynamic_sidebar( 'profile_area' ); ?>
          <?php endif; ?>
       </div>

        <div class="col-12 col-md-9">
		
    <?php 

      if ($retorno == 200) {
	
        if (count($products['products']) > 0) {
			//echo "<pre>",print_r($products),"</pre>";
			$products = $products['products'];
			
			include get_template_directory() . '/inc/showcase_wishlist.php';
        } else {
        ?>
			<div class="col-12 my-4">
				<p>Não encontramos nenhum resultado para sua busca.</p>
			</div>
        <?php
		}
      } else {
        ?>
		<div class="col-12 my-4">
			<p>Não encontramos nenhum resultado para sua busca.</p>
		</div>
        <?php
      }
      ?>
        </div>
    </div>
  </div>
</section>
<?php get_footer(); ?>
