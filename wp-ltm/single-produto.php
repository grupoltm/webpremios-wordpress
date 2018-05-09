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
    <div class="row">

        <div class="col-md-3 col-12">
          <?php include dirname(__FILE__) . '/inc/categories.php'; ?>
        </div>

        <div class="col-md-9 col-12">
		
			<?php 
				if (have_posts()){
					while (have_posts()) {
						the_post();
						$idsku =  get_post_meta( get_the_ID(), "sku", true );
						if (isset($_GET['sku'])) {
							$idsku = $_GET['sku'];
						}
						
						$detail = get_details($idsku);
						if (isset($detail->originalProductId)) {
						$sections = $detail->sections;
						$brand = $sections[count($sections)-1]->sectionType == 'Marca' ? $sections[count($sections)-1]->name : "";
						
						$vendor = $detail->vendor;
						
						$skus = $detail->skus;
						$sku = $skus[0];
						
						$imgProd = $sku->images;
						$imgProd = $imgProd[0]->mediumImage;
						
						$images = $sku->images;
						
						$status = strtolower($sku->status);
						
						$features = $detail->features;
						if (count($features) > 0) {
							$additionals = array();
							foreach ($features as $feature) {
								$additionals[$feature->type][] = $feature;
							}
						}
						
						$variants = array();
						$current = array();
						$sendCart = array();
						
						$originalId = $detail->originalProductId;
						
						foreach ($skus as $cont=>$unique) {
							
							if ($idsku == $unique->sku) {
								$originalId = $unique->originalId;
							}
							
							$skuFeatures = $unique->skuFeatures;
							if (count($skuFeatures) > 0) {
								foreach ($skuFeatures as $k=>$sf) {
									$variants[$sf->type][$sf->value][] = $unique->sku;
									if ($idsku == $unique->sku) {
										$current[] = $sf->value;
									}
									$sendCart[$unique->sku][$sf->type][$sf->value] = $unique->sku;
								}
							}
						}
						foreach ($sendCart as $k=>$sct) {
							$op = "";
							foreach ($sct as $ks=>$sc) {
								foreach ($sc as $kss=>$s){
									$op .= " data-" . $ks . "='" . $kss . "'";
								}
							}
							echo '<input class="variants" type="hidden" value="' . $k . '" ' . $op  . '/>';
						}
						
						
						$price = ltm_getPrices($idsku, $detail->vendor->id, $originalId);
						
			?>
							
			<div id="product-details">
			<div class="row">

				<div id="breadcrumb" class="col-12 d-none d-md-block">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="<?php echo site_url("/") ?>">Home</a></li>
						<?php
							foreach ($sections as $section) {
								if (strtolower($section->sectionType) == 'categoria') {
						?>
							<li class="breadcrumb-item"><a href="<?php echo home_url() ?>"><?php echo $section->name ?></a></li>
						<?php
								}
							}
						?>
							<li class="breadcrumb-item active"><?php echo $detail->name; ?></li>
						</ol>
					</nav>
				</div>

				<div class="col-md-5 col-12 images-product">
					<?php 
						if($imgProd == ''){
							echo '<img class="w-100 img-main" src="http://placehold.it/292x292/eFeFef/333333/&text=Sem%20imagem" alt="Produto sem foto"  />';
						}
						else {
							echo '<img class="w-100 img-main" src="'.$imgProd.'" alt="'.$detail->name.'"  />';
						}
					?>
					
					<div class="row no-gutters bx-thumbnails">
						<?php
						$cont = 0;
						foreach ($images as $image) {
							if($cont<18){
							?>
								<div class="col-4 col-md-2">
									<img class="w-100" 
										 src="<?php echo $image->smallImage ?>" 
										 alt="<?php echo $image->order ?> - <?php echo $section->name ?>" />
								</div>
							<?php
							}
							$cont++;
						}
						?>
					</div>
				</div>

				<div class="col-md-7 col-12 description-product">
					<?= '<span id="product-brand">'.$brand.'</span>' ?>
					<h1 data-originalId="<?php echo $originalId ?>" class="my-3 titleProduct"><?php echo $detail->name; ?></h1>
					<div class="row">
						<div class="col">
							<small class="sku-code">Código: <?php echo $idsku;?></small>
						</div>
						<div class="col-4">
							<span class="badge badge-<?php echo $status == "available" ? "success" : "danger" ?> availability">
								<?php echo $status == "available" ? "Disponível" : 'Indisponível' ?>
							</span>
						</div>
					</div>
					<div class="row align-items-center no-gutters bx-price position-relative">
						<div class="col-12 col-md-6">
							<?php
								if(validPrice($price->available, $price->regularPrice, $price->price)){
									if($price->price == $price->regularPrice) {
								?>
									<div class="scenario-default">
										<strong><?= number_format($price->price, 2, ',', '.'); ?></strong>
										<span class="currency"><?= get_option('currecy_name'); ?></span>
									</div>
								<?php } else { ?>
									<div class="scenario-from-to">
										<s><?= number_format($price->regularPrice, 2, ',', '.'); ?></s>
										<strong><?= number_format($price->price, 2, ',', '.'); ?></strong>
										<span class="currency"><?= get_option('currecy_name'); ?></span>
									</div>
								<?php }
								}
							?>
						</div>
						<div class="col-12 col-md-6 text-center">
							<img data-id="<?php echo $vendor->id ?>" src="<?php echo $vendor->logoUrl ?>" alt="<?php echo $vendor->name ?>" class="partner-brand float-md-right float-none " />	
						</div>
						<div class="text-center loading w-100 position-absolute d-none">
							<img src="<?php echo get_template_directory_uri() ?>/assets/img/loading.gif" class="w-25" />
						</div>
					</div>
					<div class="row">
						<?php
						if (count($variants) > 0) {
							$variant_item = array();
							$c = 0;
							foreach ($variants as $chave => $variant) {
								$repeats = array();
							
								if (count($variant) > 0) {
								?>
									<div class="col-12 col-md-4">
										<div class="form-group">	
											<label for="input<?php echo slugify($chave); ?>"><?php echo $chave ?></label>
											<select data-name="<?php echo $chave ?>" id="select<?php echo $c ?>" name="filter[<?php echo $chave ?>]"  class="form-control">
												<?php
												$t = 0;
												foreach ($variant as $k=>$value) {
														$selected = "";
														if (in_array($value, $current)) {
															$selected = " selected='true'";	
														}
														if (!in_array($k, $repeats)) {
															?>
															<option data-<?php echo $chave ?>="<?php echo $k ?>" <?php echo $selected ?> value="<?php echo $k ?>" ><?php echo $k ?></option>
															<?php
														}
														$repeats[] = $value;
														$t++;
												}
												?>
											</select>
										</div>
									</div>
								<?php
								
								}
								$c++;
							}
						}
						?>
					</div>
					<div class="row">
						<div class="col-12 text-center">
							<button type="button" class="btn btn-lg btn-secondary addToCart" sku="<?php echo $idsku ?>" vendorId="<?php echo $vendor->id ?>">Adicionar ao carrinho</button>	
						</div>
					</div>
				</div>
			</div>

			<div id="details">
				<div class="row">
					<div class="col-12">
						<ul class="nav nav-tabs" id="additional" role="tablist">
							<li><a class="nav-link active" id="description-tab" data-toggle="tab" href="#tab-description" role="tab" aria-controls="description" aria-selected="true">Descrição do Produto</a></li>
							<?php
								if (isset($additionals)) {
									$cont = 0;
									foreach ($additionals as $k=>$add) {
										$slug_tab = slugify($k);
								
										echo '<li><a class="nav-link" 
												id="'.$slug_tab.'-tab" 
												data-toggle="tab" 
												href="#tab-'.$slug_tab.'" 
												role="tab" 
												aria-controls="'.$slug_tab.'" 
												aria-selected="false"
												>'.mb_strtolower  ( $k , 'UTF-8').'</a></li>';
								
										$cont++;
									}
								}
							?>
						</ul>
					</div>
				</div>
				<div class="row">
					<div class="col-12">
						
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="tab-description" role="tabpanel" aria-labelledby="description-tab">
								<p class="descr text-md-left text-justify"><?php echo $detail->description; ?></p>
							</div>
						
							<?php 
								if (isset($additionals)) { 
									$cont = 0;
									foreach ($additionals as $k=>$add) {
										$slug_tab = slugify($k);
										if ($cont == 0) { $active = "ative"; }
							?>
										<div id="<?php echo'tab-'. $slug_tab ?>" class="tab-pane fade <?php echo $active ?>">
											<?php foreach ($add as $item) { ?>
												<div class="row">
													<div class="col-4"><strong><?php echo $item->name ?></strong></div>
													<div class="col-8"><p><?php echo $item->value ?></p></div>
												</div>
											<?php } ?>
										</div>
							<?php 
										$cont++; 
									} 
								} 
							?>
						</div>
					</div>
				</div>
			</div>
		<?php 
							
					} else {
						?>
						<div class="alert alert-danger my-3">
						  <?php echo $detail->message ?>
						</div>
					<?php
					}
				}
			}
		?>
        </div>

    </div>
  </div>
</section>
<?php get_footer(); ?>
