<?php
/**
 * Template Name: Busca
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
get_header(); 
include get_template_directory() . '/inc/menu.php';

$query_string = $_SERVER['QUERY_STRING'];
parse_str($query_string, $array);

$products = ltm_getProducts($array);

$retorno = $products['response']['code'];
$lastPageIndex = 0;

if ($retorno == 200) {
	$products = json_decode( $products['body'] );
	$lastPageIndex = $products->lastPageIndex;
}
?>


<section>
  <div class="container">
    <div class="row">
        <div class="col-12 col-md-3">
          <?php include get_template_directory() . '/inc/categories.php'; ?>
		  
		  <?php
			parse_str($_SERVER['QUERY_STRING'], $queryString);
			
			if (count($queryString)) {
				echo "<div class='my-3'>";
					echo '<button data-toggle="collapse" href="#collapseFilters" class="mt-0 bg-primary w-100 text-left py-2 px-2 text-white"><i class="fas fa-filter">&nbsp;</i>Filtros</button>';
					echo '<div id="collapseFilters" class="collapse show">';
						echo '<ul id="category-list" class="my-0 sub-category-list">';
						
						foreach ($queryString as $k => $v) {
							$queryCurrent = $queryString;
							$pos = strrpos(strtolower($k), "name");
							if ($pos !== false) {
								unset($queryCurrent[$k]);
								unset($queryCurrent[str_replace("Name", "Id", $k)]);
								$url_e = http_build_query($queryCurrent);
								echo '<li><a href="'. get_permalink(esc_attr( get_option('search_page'))) .'?'. $url_e .'">'.$v . ' <i class="fas fa-minus-circle">&nbsp;</i></a></li>';
							}
							if ($k == "minPrice" || $k == "maxPrice" || $k == "term") {
								unset($queryCurrent[$k]);
								$url_e = http_build_query($queryCurrent);
								echo '<li><a href="'. get_permalink(esc_attr( get_option('search_page'))) .'?'. $url_e .'"><strong>'.$v . '</strong> <i class="fas fa-minus-circle">&nbsp;</i></a></li>';
							}
						}
						echo '</ul>';
					echo '</div>';
				echo '</div>';
			}
			
			
			if (isset($products->categories)) {
				$urlCat = $queryString;
				$categories = $products->categories;
				if (count($categories) > 0) {
					echo "<div class='my-3'>";
						echo '<button data-toggle="collapse" href="#collapseCategories"  class="collapsed mt-0 bg-light w-100 text-left py-2 px-2"><i class="fas fa-tags">&nbsp;</i>Categorias</button>';
						echo '<div id="collapseCategories" class="collapse">';
							echo '<ul id="category-list" class="my-0 sub-category-list">';
							foreach ($categories as $category) {
								$urlCat["categoryId"] = $category->id;
								$urlCat["categoryName"] = $category->name;
								$urlCat_e = http_build_query($urlCat);
								
								echo '<li><a href="'. get_permalink(esc_attr( get_option('search_page'))) .'?'. $urlCat_e .'"><i class="fas fa-arrow-right">&nbsp;</i> '.$category->name . '</a></li>';
							}					
							echo '</ul>';
						echo '</div>';
					echo '</div>';
				}
			}
			if (isset($products->vendors)) {
				$urlVendor = $queryString;
				$vendors = $products->vendors;
				if (count($vendors) > 0) {
					echo "<div class='my-3'>";
						echo '<button data-toggle="collapse" href="#collapseVendors"  class="mt-0 bg-light w-100 text-left py-2 px-2"><i class="fas fa-tags">&nbsp;</i>Parceiros</button>';
						echo '<div id="collapseVendors" class="collapse">';
						echo '<ul id="category-list" class="collapsed my-0 sub-category-list">';
						foreach ($vendors as $vendor) {
							$urlVendor["vendorId"] = $vendor->id;
							$urlVendor["vendorName"] = $vendor->name;
							$urlVendor_e = http_build_query($urlVendor);
							echo '<li><a href="'. get_permalink(esc_attr( get_option('search_page'))) .'?' . $urlVendor_e.'"><i class="fas fa-arrow-right">&nbsp;</i> '.$vendor->name . '</a></li>';
						}					
						echo '</ul>';
						echo '</div>';
					echo '</div>';
				}
			}
			if (isset($products->brands)) {
				$urlBrands = $queryString;
				$brands = $products->brands;
				if (count($brands) > 0) {
					echo "<div class='my-3'>";
						echo '<button data-toggle="collapse" href="#collapseBrands"  class="mt-0 bg-light w-100 text-left py-2 px-2"><i class="fas fa-tags">&nbsp;</i>Marcas</button>';
						echo '<div id="collapseBrands" class="collapse">';
						echo '<ul id="category-list" class="collapsed my-0 sub-category-list">';
						foreach ($brands as $brand) {
							$urlBrands["brandId"] = $brand->id;
							$urlBrands["brandName"] = $brand->name;
							$urlBrands_e = http_build_query($urlBrands);
							echo '<li><a href="'. get_permalink(esc_attr( get_option('search_page'))) .'?' . $urlBrands_e .'"><i class="fas fa-arrow-right">&nbsp;</i> '.$brand->name . '</a></li>';
						}					
						echo '</ul>';
						echo '</div>';
					echo '</div>';
				}
			}
			
			if (isset($products->lowerPrice) && isset($products->higherPrice)) {
				$urlPrice = $queryString;
				if (isset($urlPrice['minPrice'])) {
					unset($urlPrice['minPrice']);
				}
				if (isset($urlPrice['maxPrice'])) {
					unset($urlPrice['maxPrice']);
				}
				
				echo "<div class='my-3'>";
						echo '<button data-toggle="collapse" href="#collapsePrices"  class="collapsed mt-0 bg-light w-100 text-left py-2 px-2"><i class="fas fa-tags">&nbsp;</i>Preço</button>';
						echo "<form action='". get_permalink(esc_attr( get_option('search_page'))) ."' method='get'>";
							echo '<div id="collapsePrices" class="collapse">';
								echo '<ul id="category-list" class="py-2 px-2 border-bottom sub-category-list">';
									echo '<li><small class="d-block mb-2">Min (R$)</small><input type="text" name="minPrice" class="border col-12 priceMask"/></li>';
									echo '<li><small class="d-block mb-2">Max (R$)</small><input type="text" name="maxPrice" class="border col-12 priceMask"/></li>';
									echo '<li><input class="my-2 bg-light w-100" type="submit" value="Filtrar" /></li>';
								echo '</ul>';
							echo '</div>';
							foreach ($urlPrice as $kup=>$up) {
								echo '<input type="hidden" name="'. $kup .'" value="'. $up .'" />';
							}
						echo '</form>';
				echo '</div>';
			
			}
			
			?>
        </div>

        <div class="col">
		
    <?php 

      if ($retorno == 200) {
		$products = $products->products;
		
        if (count($products) > 0) {
          include get_template_directory() . '/inc/showcase.php';
		  
		  if ($lastPageIndex > 1) {
			$pageCurrent = $_GET['_offset'];
			$urlPage = $queryString;
			if (isset($urlPage['_offset'])) {
				unset($urlPage['_offset']);
			}
			$urlPage_e = "&" . http_build_query($urlPage);
						
		?>
			<div class="pagination my-3 border-top py-4">
				<?php
				if ($pageCurrent > 1) {
					?>
						<div class="col-2">
							<a class="bg-light py-2 px-2 text-dark" href="<?php echo get_permalink(esc_attr( get_option('search_page'))) ?>?_offset=0<?php echo $urlPage_e ?>"><i class="align-center mr-2 fas fa-angle-double-left"></i> Primeiro</a>
						</div>
						<div class="col-2">
							<a class="bg-light py-2 px-2 text-dark" href="<?php echo get_permalink(esc_attr( get_option('search_page'))) ?>?_offset=<?php echo $pageCurrent - 1 ?><?php echo $urlPage_e ?>"><i class="align-center mr-2 fas fa-angle-left"></i> Anterior</a>
						</div>
					<?php
					$offset = 4;
				} else {
					$offset = 8;
				}
				if ($pageCurrent < ($lastPageIndex - 1)) {
					?>
						<div class="col-2 offset-<?php echo $offset ?>">
							<a class="bg-light py-2 px-2 text-dark" href="<?php echo get_permalink(esc_attr( get_option('search_page'))) ?>?_offset=<?php echo $pageCurrent + 1 ?><?php echo $urlPage_e ?>">Próximo <i class="align-center  ml-2 fas fa-angle-right"></i></a>
						</div>
						<div class="col-2">
							<a class="bg-light py-2 px-2 text-dark" href="<?php echo get_permalink(esc_attr( get_option('search_page'))) ?>?_offset=<?php echo $lastPageIndex - 1 ?><?php echo $urlPage_e ?>">Último <i class="align-center ml-2 fas fa-angle-double-right"></i></a>
						</div>
					<?php
				}
				?>
			</div>
		<?php 
		}
		  
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
