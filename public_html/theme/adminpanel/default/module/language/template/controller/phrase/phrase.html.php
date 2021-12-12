{literal}
<script src="js/mylibs/forms/jquery.cleditor.js"></script>
<script>
$Behavior.lang = function()
{	// ! Editor
	$('textarea.editor').each(function(){
		var $input = $(this),
			isFull = $input.hasClass('full');
			$input.cleditor({
				width: isFull ? 'auto' : '98%',
				height: '250px',
				bodyStyle: 'margin: 10px; font: 12px Arial,Verdana; cursor:text',
				useCSS: false
			});
		isFull && $input.parents('.cleditorMain').addClass('full');
	});
}
</script>
{/literal}
	<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>

	<div class="grid_6">
		<form action="{url link='language.phrase' page=$iPage}" class="box" method="POST" enctype="multipart/form-data">
			<div class="header">
				<h2>Axtar</h2>
			</div>
			<div class="content">
				<table class="styled">
					<tbody>
						<tr>
							<td>
								<strong>Axtarış mətni:</strong>
							</td>
							<td>
								<input type="text" name="val[search]" value="{value type='input' id='search'}"/>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Dil:</strong>
							</td>
							<td>
								<select name="val[language_id]">
										<option value="">{phrase var='language.select'}:</option>
										{foreach from=$aLanguages item=aLanguage}
											<option value="{$aLanguage.language_id}" {if isset($aForms.language_id) and $aLanguage.language_id == $aForms.language_id} selected="selected"{/if}>{$aLanguage.title}</option>
										{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<strong>Module:</strong>
							</td>
							<td>
								<select name="val[module_id]">
									<option value="">{phrase var='language.select'}:</option>
									{foreach from=$aModules key=sModule item=iModuleId}
										<option value="{$iModuleId}" {if isset($aForms.module_id) and $iModuleId == $aForms.module_id} selected="selected"{/if}>{$iModuleId}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					</tbody>
				</table>
			</div><!-- End of .content -->
			<div class="actions">
				<div class="right">
					<input type="submit" name="save" value="Axtar" class="button" />
				</div>
			</div>
		</form>
	</div><!-- End of .grid_4 -->

			<div class="grid_12">
				<div class="box">
					<div class="header">
						<h2><img class="icon" src="img/icons/packs/fugue/16x16/table.png">Dillər</h2>
					</div>
					<div class="content">
						{error}
						<form action="{url link='language.phrase' page=$iPage}" class="box" method="POST" enctype="multipart/form-data">
							<table class="styled">
								<thead>
								<tr>
									<th style="width: 5px !important;"><input type="checkbox" name="val[id]" value="" id="js_check_box_all" /></th>
									<th style="width: 80px !important;">{phrase var='language.variable'}</th>
									{if !$iLangId}<th style="width: 60px !important;">{phrase var='language.language'}</th>{/if}
									<th style="width: 150px !important;">{phrase var='language.original'}</th>
									<th style="width: 400px !important;">{phrase var='language.text'}</th>
								</tr>
								</thead>
								<tbody>
								{foreach from=$aRows key=iKey item=aRow}
								<tr id="js_row{$aRow.phrase_id}" class="checkRow{if is_int($iKey/2)} tr{else}{/if}">
									<td><input type="checkbox" name="id[]" class="checkbox" value="{$aRow.phrase_id}" id="js_id_row{$aRow.phrase_id}" /></td>
									<td title="{$aRow.name}.{$aRow.var_name}">
										<input type="text" name="null" value="{$aRow.name}.{$aRow.var_name}" size="25" style="width:95%;" onfocus="tb_show('{phrase var='language.phrase_variables' AIN_squote=true}', $.ajaxBox('language.sample', 'height=240&width=450&phrase={$aRow.name}.{$aRow.var_name}'));" />
									</td>
									{if !$iLangId}<td>{$aRow.title}</td>{/if}
									<td>{$aRow.sample_text}</td>
									<td class="t_center{if $aRow.is_translated} is_translated{/if}"><textarea class="editor" cols="30" rows="6" name="text[{$aRow.phrase_id}]" class="text" style="width:95%;">{$aRow.text|htmlspecialchars}</textarea></td>
								</tr>
								{/foreach}
								</tbody>
							</table>
							<div class="actions">
								<div class="right">
									<input type="submit" name="save" value="{phrase var='language.save_all'}" class="button" />
								</div>
							</div>
						</form>
						{pager}
					</div><!-- End of .content -->
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->
		</section><!-- End of #content -->