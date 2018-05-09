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
		<hr />
		<div class="tab tab-informacoes-basicas">
			<h2>Informações Básicas</h2>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="email_ltm">Selecione seu timezone: </label></th>
						<td>
							<select name="timezones" class="timezone">
								<?php
								$timezones = getTimezones();
								if (count($timezones) > 0) {
									foreach ($timezones as $k => $t) {
									?>
										<option value="<?php echo $t ?>" <?php echo get_option('timezones') == $t ? "selected='true'" : "" ?>><?php echo $k ?></option>
									<?php
									}
								}
								?>
							</select>
							<p class="help">
								O horário atual do seu servidor é <strong><?php echo date("H:i:s") ?></strong> (<?php echo date_default_timezone_get() ?>)
							</p>
						</td>

					</tr>
					<tr valign="top">
						<th scope="row"><label for="email_ltm">Email para Contato</label></th>
						<td>
							<input type="text" placeholder="" id="email_ltm" name="email_ltm" value="<?php echo get_option('email_ltm') ? get_option('email_ltm') : get_option('admin_email'); ?>"  style="width:500px" />
							<p class="help">
								O formulário padrão deste tema utiliza a função mail().
							</p>
						</td>

					</tr>
				</tbody>
			</table>
		</div>
		<hr />
		<div class="tab tab-configuracao-sistema">
			<h2>Configuração do Sistema</h2>
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
						<th scope="row"><label for="urlbase_ltm">Ambiente</label></th>
						<td>
							<select name="urlbase_ltm"  id="urlbase_ltm">
								<option <?php echo get_option('urlbase_ltm') == 'https://cloudloyaltyapimanprd.azure-api.net/cloudloyalty/v1' ? 'selected="true"' :  '' ?> value="https://cloudloyaltyapimanprd.azure-api.net/cloudloyalty/v1">Produção</option>
								<option <?php echo get_option('urlbase_ltm') == 'https://hml-cloudloyaltyapiman-px.webpremios.com.br/cloudloyalty/v1' ? 'selected="true"' :  '' ?> value="https://hml-cloudloyaltyapiman-px.webpremios.com.br/cloudloyalty/v1">Homologação</option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row"><label for="ltm_api_key">Chave da API</label></th>
						<td>
							<input type="text" placeholder="API Cloud Loyalty" id="ltm_api_key" name="api_key" value="<?php echo esc_attr( get_option('api_key') ); ?>" style="width:500px" />
						</td>

					</tr>
					<tr valign="top">
						<th scope="row"><label for="ltm_authorization">Autorização</label></th>
						<td>
							<input type="text" placeholder="Autorização" id="ltm_authorization" name="Authorization" value="<?php echo esc_attr( get_option('Authorization') ); ?>" style="width:500px" />
						</td>

					</tr>
					<tr valign="top">
						<th scope="row"><label for="ltm_campaign_id">Código da Campanha</label></th>
						<td>
							<input type="text" placeholder="Código da Campanha" id="ltm_campaign_id" name="campaign_id" value="<?php echo esc_attr( get_option('campaign_id') ); ?>" />
							<p class="help">
								Digite sua Chave API e o Código da Campanha para conectar com a sua conta no LTM Cloud Loyalty.
								<a target="_blank" href="https://grupoltm.com.br/contato">Entre em contato.</a>
							</p>
						</td>

					</tr>
					<tr valign="top">
						<th scope="row"><label for="ltm_profile_id">ProfileId</label></th>
						<td>
							<input type="text" placeholder="ProfileId" id="ltm_profile_id" name="profile_id" value="<?php echo esc_attr( get_option('profile_id') ); ?>" />
						</td>

					</tr>
					<tr valign="top">
						<th scope="row"><label for="currecy_name">Nome da moeda</label></th>
						<td>
							<input type="text" placeholder="" id="currecy_name" name="currecy_name" value="<?php echo esc_attr( get_option('currecy_name') ); ?>" />
							<p class="help">
								Aqui você pode cadastrar um nome fictício para sua moeda.<br>
								Caso não coloque nada, usaremos o termo "pontos".
							</p>
						</td>

					</tr>
				</tbody>
			</table>
		</div>
		<hr />
		<div class="tab tab-limpar-cache">
			<h2>Limpar Cache</h2>
			<p class="help">
				Antes de limpar o cache é necessário salvar as outras informações para não perde-las.
			</p>
			<table class="form-table">
				<tbody>
					<tr valign="top">
						<th scope="row"><label for="email_ltm">Cache de Categorias: </label></th>
						<td>
							<a href="<?php echo admin_url('admin.php?page=dashboard_ltm&cache=categories') ?>" class="button button-secondary">Limpar</a>
						</td>
					</tr>
					
				</tbody>
			</table>
		</div>
		<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Salvar alterações"></p>
	</form>
</div>