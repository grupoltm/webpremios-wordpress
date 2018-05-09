<div class="wrap">
	<h1>
		<span class="ltm-ico"></span>
		LTM Cloud Loyalty
	</h1>
	<p>
		Faça a configuração da sua campanha aqui.
	</p>
	<form method="post" action="options.php"> 
	<?php settings_fields( 'ltm-settings-group' ); ?>
    <?php do_settings_sections( 'ltm-settings-group' ); ?>

		
		<table class="form-table">
			<tbody>
				<tr valign="top">
					<th scope="row">
						Status
					</th>
					<td>
						<span class="status <?php echo get_option('api_status') ? 'positive' : "negative" ?>"><?php echo get_option('api_status') ? 'Conectado' : "Não Conectado" ?></span>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="ltm_api_key">Chave da API</label></th>
					<td>
						<input type="text" placeholder="API Cloud Loyalty" id="ltm_api_key" name="api_key" value="<?php echo esc_attr( get_option('api_key') ); ?>" />
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="ltm_campaign_id">Código da Campanha</label></th>
					<td>
						<input type="text" placeholder="API Cloud Loyalty" id="ltm_campaign_id" name="campaign_id" value="<?php echo esc_attr( get_option('campaign_id') ); ?>" />
						<p class="help">
							Digite sua Chave API e o Código da Campanha para conectar com a sua conta no LTM Cloud Loyalty.
							<a target="_blank" href="https://grupoltm.com.br/contato">Entre em contato.</a>
						</p>
					</td>

				</tr>

			</tbody>
		</table>
		
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Salvar alterações"></p>
	</form>
</div>