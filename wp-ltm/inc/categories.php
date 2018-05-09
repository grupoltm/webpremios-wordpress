<?php
	$currentPage = get_the_ID();

	$pages = array(get_option("search_page"), get_option("address_page"), get_option("profile_page"), get_option("password_page"), get_option("wishlist_page"), get_option("orders_page"), get_option("extract_page")); 
	$varButton = "";
	$varDiv = "";
	if (in_array($currentPage, $pages)) {
		$varButton = 'data-toggle="collapse" href="#collapseCats"';
		$varDiv = 'id="collapseCats" class="panel-collapse collapse"';	
	}
?>
<button id="btn-categories" <?php echo $varButton ?>><i class="fas fa-tags">&nbsp;</i>Categorias</button>
<?php 
    
    $nextUpdate = get_option("ltm_next", true);
    
    if ($nextUpdate == 1 || $nextUpdate <= date("Ymdh")) {
        $categories = ltm_getCategories();
        $json = $categories['body'];
    
        delete_option( 'ltm_next');
        add_option( 'ltm_next', date("Ymdh", strtotime("+ 2 hours")));
        add_option( 'ltm_categories', $json, '', true );
    } else {
        $json =  get_option("ltm_categories", true);
    }
    $categories = json_decode( $json );
    
	echo '<div '. $varDiv .'>';
		echo '<ul id="category-list">';
		
		foreach ($categories as $cat) {
			echo '<li><a data-id="'.$cat->id.'" href="'. get_permalink(esc_attr( get_option('search_page'))) .'?categoryName='. $cat->name .'&categoryId='. $cat->id .'"><i class="fas fa-bolt">&nbsp;</i> '.$cat->name;
				if (count($cat->subcategories) > 0) {
					echo '<i class="fas fa-chevron-right">&nbsp;</i></a><ul>';
					foreach ($cat->subcategories as $subcat) {
					   echo '<li><a data-id="'.$subcat->id.'" href="'. get_permalink(esc_attr( get_option('search_page'))) .'?subcategoryId='. $subcat->name .'&subcategoryId='. $subcat->id .'">'.$subcat->name.'</a></li>';
					}
					echo '</ul>';
				}
				else {
					echo '</a></li>';
				}         
			echo '</li>';
		}
		
		echo '</ul>';
	echo '</div>';
?>