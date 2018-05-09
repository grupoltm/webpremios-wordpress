<ul id="bx-showcase" class="row">
<?php
    foreach($products as $prod) {
        $productURL = get_product_url($prod->sku);
	
        $price = ltm_getPrices($prod->sku, $prod->vendor->id, $prod->originalId);
		
		$wishlistitens = array();
		if (isset($_COOKIE['wishlistitens'])) {
			$wishlistitens = $_COOKIE['wishlistitens'];
			if ($wishlistitens != "")
				$wishlistitens = explode("|", $wishlistitens);
		}
		
        if(validPrice($price->available, $price->regularPrice, $price->price)){
?>
    <li data-sku="<?= $prod->sku; ?>" class="col-12 col-sm-6 col-md-4">
        <div class="photo">
            <div class="inner">
            <?php 
            if($price->price != $price->regularPrice) {
                $discount = getPrice($price->price, $price->regularPrice);
            ?>
                <span>-<?= $discount; ?>%</span>
            <?php } ?>
                <a href="<?= $productURL; ?>" style="background-image:url('<?= $prod->imageUrl; ?>')">
                    <!-- <img src="http://placehold.it/292x292/cccccc/333333/" alt="" class="w-100" /> -->
                    <!-- <img src="<?= $prod->imageUrl; ?>" alt="<?= $prod->name; ?>" class="w-100" /> -->
                </a>
                
                <ul class="actions">
                    <li><a href="#" class="<?php echo in_array($prod->sku, $wishlistitens) ? "fas" : "far" ?> fa-heart addWishList"></a></li>
                </ul>
            </div>
        </div>
        <div class="info">
            <p>
                <a href="<?= $productURL; ?>"><?= $prod->name; ?></a>
            </p>
        <?php 
            if($price->price == $price->regularPrice) {
        ?>
            <div class="scenario-default">
                <a href="<?= $productURL; ?>">
                    <strong><?= number_format($price->price, 2, ',', '.'); ?></strong>
                    <span class="currency"><?= get_option('currecy_name'); ?></span>
                </a>
            </div>
        <?php } else {?>
            <div class="scenario-from-to">
                <a href="<?= $productURL; ?>">
                    <s><?= number_format($price->regularPrice, 2, ',', '.'); ?></s>
                    <strong><?= number_format($price->price, 2, ',', '.'); ?></strong>
                    <span class="currency"><?= get_option('currecy_name'); ?></span>
                </a>
            </div>
        <?php }?>
            <div class="partner">
                <a href="<?= $productURL; ?>">
                    <!-- <img src="http://placehold.it/136x50/cccccc/333333/" alt="" /> -->
                    <img src="<?= $prod->vendor->logoUrl; ?>" alt="<?= $prod->vendor->name; ?>" />
                </a>
            </div>
        </div>
    </li>
<?php 
        }
    } 
?>
</ul>