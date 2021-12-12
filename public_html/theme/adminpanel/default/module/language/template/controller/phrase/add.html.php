<!-- Here goes the content. -->
<section id="content" class="container_12 clearfix {$sFullControllerName}" data-sort=true>
	<h1 class="grid_12">{phrase var='language.title'}</h1>
	
	
{if $sCachePhrase}
	<div class="grid_6">
		<form action="#" class="box" method="POST" enctype="multipart/form-data">
			<div class="header">
				<h2>Language</h2>
			</div>
			<div class="content">
				<table class="styled">
					<thead>
						<tr>
							<th style="width:20%;">
								ID
							</th>
							<th style="width:80%;">
								CODE
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<strong>{phrase var='language.php'}</strong>
							</td>
							<td>
								<input type="text" name="php" value="AIN::getPhrase('{$sCachePhrase}')" size="40" onclick="this.select();" />				
							</td>
						</tr>
						<tr>
							<td>
								<strong>{phrase var='language.php_single_quoted'}</strong>
							</td>
							<td>
								<input type="text" name="php" value="' . AIN::getPhrase('{$sCachePhrase}') . '" size="40" onclick="this.select();" /> 
							</td>
						</tr>
						<tr>
							<td>
								<strong>{phrase var='language.php_double_quoted'}</strong>
							</td>
							<td>
								<input type="text" name="php" value="&quot; . AIN::getPhrase('{$sCachePhrase}') . &quot;" size="40" onclick="this.select();" /> 
							</td>
						</tr>
						<tr>
							<td>
								<strong>{phrase var='language.html'}</strong>
							</td>
							<td>
								<input type="text" name="html" value="{literal}{{/literal}phrase var='{$sCachePhrase}'{literal}}{/literal}" size="40" onclick="this.select();" /> 
							</td>
						</tr>
						<tr>
							<td>
								<strong>{phrase var='language.js'}</strong>
							</td>
							<td>
								<input type="text" name="html" value="oTranslations['{$sCachePhrase}']" size="40" onclick="this.select();" /> 
							</td>
						</tr>
						<tr>
							<td>
								<strong>{phrase var='language.text'}</strong>
							</td>
							<td>
								<input type="text" name="html" value="{$sCachePhrase}" size="40" onclick="this.select();" /> 
							</td>
						</tr>
					</tbody>
				</table>
			</div><!-- End of .content -->			
		</form><!-- End of .box -->
	</div><!-- End of .grid_4 -->
{/if}

	<div class="grid_6">
		{error}
		<form action="{url link='current'}" class="box" method="POST" enctype="multipart/form-data">
			<div class="header">
				<h2>Language</h2>
			</div>
			<div class="content">
			
				<div class="row">
					<label for="module">
						<strong>{phrase var='language.module'}:</strong>
					</label>
					<div>
					<select name="val[module]">
					{foreach from=$aModules key=sModule item=iModuleId}
						<option value="{$iModuleId}" {if isset($aForms.module_id) and $iModuleId == $aForms.module_id} selected="selected"{/if}>{$iModuleId}</option>
					{/foreach}
					</select>									
					</div>
				</div>
				<div class="row">
					<label for="var_name">
						<strong>{phrase var='language.varname'}:</strong>
					</label>
					<div>
						<input type="text" name="val[var_name]" size="40" id="var_name" maxlength="100" value="{value type='input' id='var_name'}" />					
					</div>
				</div>
				<div class="row">
					<label for="module">
						<strong>{phrase var='language.text'}:</strong>
					</label>
					<div>
						{foreach from=$aLanguages item=aLanguage} 
							<b>{$aLanguage.title}</b>
							<textarea cols="50" rows="8" name="val[text][{$aLanguage.language_id}]" style="margin: 0;"></textarea>
						{/foreach}					
					</div>
				</div>
			</div><!-- End of .content -->
			<div class="actions">
				<div class="right">
					<input type="submit" value="Yadda saxla" name=submit />
				</div>
			</div><!-- End of .actions -->					
		</form><!-- End of .box -->
	</div><!-- End of .grid_4 -->
</section>	
