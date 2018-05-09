<?php
/**
 * The template for displaying the footer
 *
 * @package WordPress
 * @subpackage LTM Cloud Loyalty
 * @since LTM Cloud Loyalty 1.0
 */
?>
            <footer>
                <section class="warning">
                    <div class="container">
                        <p>
                            O catálogo de premiação é atualizado periodicamente e automaticamente pelos parceiros, 
                            e os produtos e preços poderão sofrer alterações durante a navegação, sem aviso prévio, 
                            devendo ser consultados pelo interessado no momento da conclusão efetiva do resgate.
                        </p>
                    </div>
                </section>
                <section class="legal-info">
                    <div class="container">
                        <div class="row align-items-center">
							<div class="col-12 col-md-2 text-md-left text-center">
                                <img src="<?= get_template_directory_uri(); ?>/assets/img/ltm/logo-color-text-white.png" width="80" />
                            </div>
                            <div class="col-12 col-md-10">
                                <p>
                                    Informações legais: 
                                    WEB PREMIOS COMÉRCIO E SERVIÇOS PROMOCIONAIS LTDA - 
                                    CNPJ: 08.845.775/0001-70 - Inscrição Estadual: 206.247.436.112 <br class="d-none d-md-nome">
                                    Alameda Rio Negro, 585 Bloco C - 7&ordm; andar - 06454-000 - Barueri - SP
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </footer>
        </main>

        <script src="<?= get_template_directory_uri(); ?>/assets/lib/jquery/jquery-3.3.1.min.js"></script>
        <script src="<?= get_template_directory_uri(); ?>/assets/lib/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
        <script src="<?= get_template_directory_uri(); ?>/assets/js/fe.js"></script>
        <script>
				<?php
				$balance = ltm_getBalance();
				?>
				pointsValue = <?= $balance; ?>;
				
				$(function(){
					if ($("td.cartTotal").attr("data-total") > pointsValue) {
						$(".btn-buy").prop( "disabled", true );
					} else {
						$(".btn-buy").prop( "disabled", false );
					}
				})
				
                $('.quantity').bind('input', function() { 
					quantity = $(this).val();
					if (quantity != "" || quantity > 0) {
						price = $(this).parents(".cart-item").find(".cart-price").attr('data-value');
						total = price * quantity;
						$(this).parents(".cart-item").find(".cart-total").attr('data-value', total);
						total = forMoney(total.toFixed(2));
						$(this).parents(".cart-item").find(".cart-total").text(total);						
					}
					totalValue = 0;
					totalQuantity = 0;
					price = 0;
					total = 0;
					quantity = 0;
					$('.quantity').each(function(i,d){
						quantity = $(d).val()
						price = $(d).parents(".cart-item").find(".cart-price").attr('data-value');
						total = price * quantity;
						totalValue += Number(total);
						totalQuantity += Number(quantity);
					})
					$(".totalValue").text(forMoney(totalValue));
					$(".totalValue").attr("data-total", totalValue);
					$(".totalQuantity").text((totalQuantity));
					$(".totalQuantity").attr("data-total", totalValue);
					$(".cartTotal").attr("data-total", totalValue + Number($(".totalTax").data("total")));
					$(".cartTotal").text(forMoney($("td.cartTotal").attr("data-total")));
					
					if ($("td.cartTotal").attr("data-total") > pointsValue) {
						$(".btn-buy").prop( "disabled", true );
					} else {
						$(".btn-buy").prop( "disabled", false );
					}
					
				});
				$('.quantity').on('blur', function() { 
					that = $(this).parents(".cart-item");
					$.ajax({
						url: urlSite,
						method: "POST",
						data: { vendorId: $(".vendorId", that).data('value'), quantity: $(".quantity", that).val(), sku: $(".sku", that).data('value') }
					}).done(function(data){
						console.log(data);
					})
				})
				$(".getTax").on("click", function(){
					$(".cartInfos > table").fadeTo( "slow" , 0.1, function(){
						$(".loading").fadeTo( "fast" , 1);
						$(".loading").removeClass("d-none");
					});
					
					$.ajax({
						url: urlSite,
						method: "POST",
						data: { zipcode: $(".inputTax").val() }
					}).done(function(data){
						if ($.isNumeric( data )) {
							$(".totalTax").text(forMoney(data));
							$(".totalTax").attr("data-total", data);
							
							
							$(".cartTotal").attr("data-total", Number($(".totalValue").attr("data-total")) + Number($(".totalTax").data("total")));
							$(".cartTotal").text(forMoney($("td.cartTotal").attr("data-total")));
						}
						$(".cartInfos > table").fadeTo( "slow" , 1, function(){
							$(".loading").fadeTo( "fast" , 0);
							$(".loading").addClass("d-none");
						});
					
					})
					
				})
				$(".step-shipping").on("click", function(){
						$(".btn-checkout").prop( "disabled", true );
						
						$("#collapseCheckout table").fadeTo( "slow" , 0.1, function(){
							$(".loading").fadeTo( "fast" , 1);
							$(".loading").removeClass("d-none");
						});
						
						$.ajax({
							url: urlSite,
							method: "POST",
							data: { zipcode: $(".inputTax").val(), typeshipping: $(this).parents("#collapseAddress").find("input[name='endereco']:checked").val() }
						}).done(function(data){
							
							if ($.isNumeric( data )) {
								$(".tax").text(forMoney(data));
								$(".tax").attr("data-value", data);
								var valor = 0;
								$("td[data-value]").each(function(a,b){
									valor += Number($(b).attr("data-value"));
								})
								$(".total").attr("data-total", valor);
								
								if (valor > pointsValue) {
									$(".btn-checkout").prop( "disabled", true );
								} else {
									$(".btn-checkout").prop( "disabled", false );
								}
								$(".total").text(forMoney(valor));
								
							}
								
							$("#collapseCheckout table").fadeTo( "slow" , 1, function(){
								$(".loading").fadeTo( "fast" , 0);
								$(".loading").addClass("d-none");
							});						
						})
										
				})
				<?php
					if (isset($_GET['erro'])) {
						?>
							$('.retorno-erro-sm').modal();
						<?php
					}
				?>
				$(".btn-delete-item").on("click", function(){
					that = this;
					$.ajax({
						url: urlSite + "?deleteItem=" + $(that).parents("tr").find(".sku").data("value"),
					}).done(function(data){
						$(that).parents("tr").remove();
					})
					return false;
				})
				
				
				function forMoney(n, c, d, t) {
					c = isNaN(c = Math.abs(c)) ? 2 : c, d = d == undefined ? "," : d, t = t == undefined ? "." : t, s = n < 0 ? "-" : "", i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
					return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
				}
        </script>
        <?php wp_footer(); ?>

    </body>
</html>
