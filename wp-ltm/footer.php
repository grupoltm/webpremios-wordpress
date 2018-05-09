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
                <section class="main">
                    <div class="container">
                        <div class="row">
                            <?php if ( is_active_sidebar( 'widget_1_footer' ) ) : ?>
								<?php dynamic_sidebar( 'widget_1_footer' ); ?>
							<?php endif; ?>
                            <?php if ( is_active_sidebar( 'widget_2_footer' ) ) : ?>
								<?php dynamic_sidebar( 'widget_2_footer' ); ?>
							<?php endif; ?>
                            <?php if ( is_active_sidebar( 'widget_3_footer' ) ) : ?>
								<?php dynamic_sidebar( 'widget_3_footer' ); ?>
							<?php endif; ?>
                            <?php if ( is_active_sidebar( 'widget_4_footer' ) ) : ?>
								<?php dynamic_sidebar( 'widget_4_footer' ); ?>
							<?php endif; ?>
                        </div>
                    </div>
                </section>
                <section class="legal-info">
                    <div class="container">
                        <div class="row align-items-center">
							<div class="col-12 col-md-2 text-md-left text-center">
                                <img src="<?= get_template_directory_uri(); ?>/assets/img/ltm/logo-color-text-white.png" width="80" />
                            </div>
                            <div class="col-12 col-md-10 text-md-left text-center">
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
        <script src="<?= get_template_directory_uri(); ?>/assets/lib/jquery.mask/js/jquery.mask.min.js"></script>        
		<script src="<?= get_template_directory_uri(); ?>/assets/lib/jquery.dataTables/js/jquery.dataTables.min.js"></script>
        <script src="<?= get_template_directory_uri(); ?>/assets/js/fe.js"></script>

        <script>
				$(function(){
					if ($('.priceMask').length > 0) {
						$('.priceMask').mask('000000000000000.00', {reverse: true});	
					}
					
					
					if ($('.maskDate').length > 0) {
						$('.maskDate').mask('00/00/0000');	
					}
					
					$('.datatable').DataTable({
						"language": {
							"sEmptyTable": "Nenhum registro encontrado",
							"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
							"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
							"sInfoFiltered": "(Filtrados de _MAX_ registros)",
							"sInfoPostFix": "",
							"sInfoThousands": ".",
							"sLengthMenu": "_MENU_ resultados por página",
							"sLoadingRecords": "Carregando...",
							"sProcessing": "Processando...",
							"sZeroRecords": "Nenhum registro encontrado",
							"sSearch": "Pesquisar",
							"oPaginate": {
								"sNext": "Próximo",
								"sPrevious": "Anterior",
								"sFirst": "Primeiro",
								"sLast": "Último"
							},
							"oAria": {
								"sSortAscending": ": Ordenar colunas de forma ascendente",
								"sSortDescending": ": Ordenar colunas de forma descendente"
							}
						}
					});
				})

                $("#select0").on("change", function(){
                    var type = $(this).data('name').toLowerCase();
					
					selecionados = $("input[data-"+ type +"='"+ $("option:selected", this).data(type) +"']")
					
					if ($("#select1").length > 0) {
						var temp = [];
						$("#select1").empty();
						$('#select1').append($('<option>', {
							value: "Escolha uma opção",
							text: "Escolha uma opção"
						}));
						$(selecionados).each(function(a,b){
							type_1 = $("#select1").data("name").toLowerCase();
							$("#select1").append("<option " + "data-" + type_1 + "='" + $(b).attr("data-" + type_1) + "' value='"+ $(b).attr("data-" + type_1) +"'>"+ $(b).attr("data-" + type_1) +"</option>");
						})
					} else {
						updatePreview();
					}
					
                })
                $("#select1").on("change", function(){
                    updatePreview();
                })
				
				$(".addToCart").on("click", function(){
					$(".bx-price > div").fadeTo( "slow" , 0.1, function(){
						$(".loading").fadeTo( "fast" , 1);
						$(".loading").removeClass("d-none");
						
					});
					
					$.ajax({
						url: urlSite,
						method: "POST",
						data: { cart: "add", sku: $(this).attr('sku'), vendorId: $(this).attr('vendorId') }
					}).done(function(data){
						if (data.trim() == 'success') {
							//var success = '<div class="col-12"><div class="addedCart alert alert-success alert-dismissible fade show" role="alert">Produto adicionado com sucesso!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>';
							//$(".addToCart").parent().before(success);
							window.location= urlCart;
						} else {
							var error = '<div class="col-12"><div class="addedCart alert alert-danger alert-dismissible fade show" role="alert">Não foi possível adicionar o produto!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>';
							$(".addToCart").parent().before(error);
						}
						
						$(".loading").addClass("d-none");
						$(".bx-price > div").fadeTo( "slow" , 1)	

					})
				})
				
				function updatePreview(){
					temp =  [];
					if ($("#select0").length > 0) {
						that = $("#select0");
						var type = $(that).data('name').toLowerCase();
						temp.push("[data-"+ type +"='"+ $("option:selected", that).data(type) +"']");
					}
					if ($("#select1").length > 0) {
						that = $("#select1");
						var type = $(that).data('name').toLowerCase();
						temp.push("[data-"+ type +"='"+ $("option:selected", that).data(type) +"']");
					}
					if (temp.length > 0) {
						sku = $("input.variants" + temp.join("")).val();
						vendorId = $(".partner-brand[data-id]").data('id');
						originalId = $(".titleProduct").attr('data-originalId');
						
						$(".bx-price > div").fadeTo( "slow" , 0.1, function(){
							$(".loading").fadeTo( "fast" , 1);
							$(".loading").removeClass("d-none");
							
						});
						
						$.ajax({
							url: urlSite,
							method: "POST",
							data: { sku: sku, vendorId: vendorId, originalId: originalId }
						}).done(function(data){
							
							$(".addToCart").attr("vendorId", vendorId);
							$(".addToCart").attr("sku", sku);
							
							
							data = JSON.parse(data);
							
							if (data.regularPrice == data.price) {
								$(".bx-price .scenario-default strong").text(data.price);
							} else {
								$(".bx-price .scenario-from-to strong").text(data.price);
								$(".bx-price .scenario-from-to s").text(data.regularPrice);
							}
							$(".loading").addClass("d-none");
							$(".bx-price > div").fadeTo( "slow" , 1)	
							
						})
						
						
						
					}
				}
				
				
				
				
        </script>
        <?php wp_footer(); ?>

    </body>
</html>
