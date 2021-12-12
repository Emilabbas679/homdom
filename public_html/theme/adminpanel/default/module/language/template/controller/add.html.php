{if isset($bImportingPhrases) and $bImportingPhrases == true}
	<?='<meta http-equiv="refresh" content="2;url=' . $this->url()->makeUrl('language.add', array('import-phrase' => $this->_aVars['sLanguageId'], 'page' => $this->_aVars['iPage'])) . '">'?>	
{/if}
<!-- Here goes the content. -->
<section id="content" class="container_12 clearfix {$sFullControllerName}" data-sort=true>
	<h1 class="grid_12">{required}{phrase var='language.create_title'}:</h1>
	<div class="grid_6">
		{error}
		<form action="{url link='language.add'}" class="box" method="POST" enctype="multipart/form-data">
			{if $bIsEdit}
				<div><input type="hidden" name="id" value="{$aForms.language_id}" /></div>
			{/if}
			<div class="header">
				<h2>Language</h2>
			</div>
			<div class="content">
				{if !$bIsEdit}
					<div class="row">
						<label for="parent_id">
							<strong>{phrase var='language.create_from'}:</strong>
						</label>
						<div>
						<select name="val[parent_id]">
								<option value="">{phrase var='language.select'}:</option>
								{foreach from=$aLanguages item=aLanguage}
									<option value="{$aLanguage.language_id}">{$aLanguage.title}</option>
								{/foreach}				
						</select>									
						</div>
					</div>
				{/if}	
					
				<div class="row">
					<label for="var_name">
						<strong>{required}{phrase var='language.name'}:</strong>
					</label>
					<div>
						<input type="text" name="val[title]" value="{value type='input' id='title'}" size="40" />
					</div>
				</div>
				

				{if ! $bIsEdit}				
				<div class="row">
					<label for="var_name">
						<strong>
							{required}{phrase var='language.language_abbreviation_code'}:
						</strong>
					</label>
					<div>
						<input type="text" name="val[language_code]" value="{value type='input' id='language_code'}" size="2" maxlength="2" style="width: 60px;" />
					</div>
				</div>		
				{/if}	
			</div><!-- End of .content -->
			<div class="actions">
				<div class="right">
					<input type="submit" value="{phrase var='language.submit'}" name=submit />
				</div>
			</div><!-- End of .actions -->					
		</form><!-- End of .box -->
	</div><!-- End of .grid_4 -->
</section>	
