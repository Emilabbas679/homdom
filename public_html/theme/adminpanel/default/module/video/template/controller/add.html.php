<div class="content">
	<h2>{if $bIsEdit == true}Update Video{else} Add Video {/if}</h2>
	<form name="update" enctype="multipart/form-data" action="{url link='current'}" method="post" onsubmit="return validateFormOnSubmit(this, 'Please fill in the required fields (highlighted)')">
		<div class="container row-fluid" id="post-page">
		
		
		
			<div class="span9">
				<div class="widget border-radius4 shadow-div">
					<h4>Title &amp; Description</h4>
					<div class="control-group">
						<input name="val[title]" type="text" id="must" value="{value type='input' id='title'}" style="width: 99%;"/>
						<div class="permalink-field" style="display: none;" >
							<strong>Permalink:</strong> /<input class="permalink-input" type="text" name="slug" value="{value type='input' id='title'}"/>
						</div>
					</div>
					<div class="control-group">
						<div class="pull-right" style=" position: absolute; top: -2px; right: 0px;">
							<span class="btn btn-mini btn-upload"><span id="ButtonPlaceHolder"></span></span>
							<small>
							<div id="fsUploadProgress">
							</div>
							</small>
							<div id="divStatus">
							</div>
							<ol id="uploadLog">
							</ol>
						</div>
					</div>
					<div class="controls">
						<textarea name="val[description]" cols="100" id="textarea-WYSIWYG" class="tinymce" style="width:100%">{value type='textarea' id='description'}</textarea>
						<span class="autosave-message">&nbsp;</span>
					</div>
				</div>	
				
				{if $bIsEdit == true}
				<div class="widget border-radius4 shadow-div">
					<h4>Embed Code <i class="icon-info-sign" rel="popover" data-trigger="hover" data-animation="true" title="Info" data-content="Add or edit the embed code ONLY if you wish to change this video's source. Once an embed code is given, PHP Melody will consider it to be the default video."></i></h4>
					<div class="control-group">
						<div class="controls">
							<textarea name="embed_code" rows="2" class="textarea-embed" onclick="this.focus();this.select()"><iframe src='https://player.baku.tv/embed/{$aForms.id}' width='560' height='315' frameborder='0' allowfullscreen></iframe></textarea>
							<span class="help-block">Accepted HTML tags: <strong>&lt;iframe&gt;</strong><strong>&lt;embed&gt;</strong><strong>&lt;object&gt;</strong><strong>&lt;param&gt;</strong><strong>&lt;video&gt;</strong> and <strong>&lt;script&gt;</strong></span>
						</div>
					</div>
				</div>
				{/if}
				
				
				
			</div>
			<!-- .span8 -->
			
			
			
			
			<div class="span3">
				<div class="widget border-radius4 shadow-div">
					<div class="pull-right">
						<span class="btn btn-mini btn-upload-widget"><span id="thButtonPlaceholder"></span></span>
					</div>
					<h4>Thumbnail</h4>
					<div class="control-group container-fluid">
						<div class="controls row-fluid">
							<small>
							<div id="thUploadProgress">
							</div>
							</small>
							<div class="pm-swf-upload">
								<ol id="uploadThumbLog">
								</ol>
							</div>
<div id="showThumb">							
							{if isset($aForms.pic) }
							
								<a href="#" id="show-thumb" rel="tooltip" title="Click here to specify a custom thumbnail URL"><img src="/file/video/pic/{$aForms.pic}" id="must" style="display:block;min-width:120px;width:100%;min-height:80px; no-repeat center center;"/></a>
								<div class="">
									<div id="show-opt-thumb">
										<br/>
										<input type="text" name="val[pic]" value="{$aForms.pic}" class="bigger span10" placeholder="http://"/><i class="icon-info-sign" rel="tooltip" data-position="top" title="The existing thumbnail will be replaced after saving this form."></i>
									</div>
								</div>
								<!-- .span8 -->
							
							{else}
							 <a href="#" id="show-thumb" rel="tooltip" title="Click here to specify a custom thumbnail URL" class="pm-sprite no-thumbnail"></a>
							{/if}
							</div>
							<div class="">
							</div>
							<!-- .span4 -->
						</div>
						<!-- .controls .row-fluid -->
					</div>
				</div>			

				
				<div class="widget border-radius4 shadow-div">
					<h4>Category</h4>
					<div class="control-group">
						<div class="controls">
							<select name='val[category_id]' id='main_select_category must' class='category_dropdown span12' >{$aCategories}</select>
						</div>						
					</div>
				</div>
				<!-- .widget -->

				<div class="widget border-radius4 shadow-div">
					<h4>Language</h4>
					<div class="control-group">
						<div class="controls">
							<select name='val[language_id]' id='main_select_category must' class='category_dropdown span12' >
								{foreach from=$aLanguages item=aLanguage}
									<option value="{$aLanguage.language_id}"{value type='select' id='language_id' default=$aLanguage.language_id}>{$aLanguage.title}</option>
								{/foreach}
							
							</select>
						</div>						
					</div>
				</div>
				<!-- .widget -->
				
				
				<div class="widget border-radius4 shadow-div">
					<div class="pull-right">
						<span class="btn btn-mini btn-upload-widget"><span id="changeFlvButtonPlaceholder"></span></span>
					</div>
					<h4>Source File</h4>
					<div class="control-group container-fluid">
						<div class="controls row-fluid">
							<small>
							<div id="changeFlvUploadProgress">
							</div>
							</small>
							<div class="pm-swf-upload">
								<ol id="uploadFlvLog">
								</ol>
							</div>							
							<div id="showFlv">
								{if isset($aForms.source_id) and isset($aForms.url_flv) and $aForms.source_id == 1}
								<input type="hidden" name="val[source_id]" value="1">
								<input type="hidden" name="val[url_flv]" value="{value type='input' id='url_flv'}">
								<span class="pull-right">
									<i class="icon-download opac7"></i><strong><a href="/file/video/file/{$aForms.url_flv}" title="Download file">Download</a></strong>
								</span>
								<strong>{$aForms.url_flv}</strong>
								{/if}
							</div>							
						</div>
					</div>
				</div>
				
				<div class="widget border-radius4 shadow-div">
					<h4>Video Details</h4>					
					
					<div class="control-group">
						<label class="control-label" for="">Publish date: {if $bIsEdit == true}<span id="value-publish"><strong><?php echo date("M d, Y g:i A", $this->_aVars['aForms']['added'] );?></strong></span>{else}<span id="value-publish"><strong>immediately</strong></span>{/if}  <a href="#" id="show-publish">Edit</a></label>
						<div class="controls" id="show-opt-publish">
							<?php echo ( ! isset($this->_aVars['aForms']['date_month']) ) ? show_form_item_date( $this->_aVars['aForms']['added'] ) : show_form_item_date(); ?>
						</div>
					</div>



					
					<div class="control-group">
						<label class="control-label" for="">Active: <span id="value-register"><strong>{if isset($aForms.is_active) and $aForms.is_active == 1}yes{else}no{/if}</strong></span> <a href="#" id="show-visibility">Edit</a></label>
						<div class="controls" id="show-opt-visibility">
							<label class="checkbox inline"><input type="radio" name="val[is_active]" id="is_active" value="1" {value type='radio' id='is_active' default='1'}  /> Yes</label>
							<label class="checkbox inline"><input type="radio" name="val[is_active]" id="is_active" value="0" {value type='radio' id='is_active' default='0' selected='true'} /> No</label>
						</div>
					</div>	

					<div class="control-group">
						<label class="control-label" for="">Top5: <span id="value-register"><strong>{if isset($aForms.top5) and $aForms.top5 == 1}yes{else}no{/if}</strong></span> <a href="#" id="show-Top5">Edit</a></label>
						<div class="controls" id="show-opt-Top5">
							<label class="checkbox inline"><input type="radio" name="val[top5]" id="is_active" value="1" {value type='radio' id='top5' default='1'}  /> Yes</label>
							<label class="checkbox inline"><input type="radio" name="val[top5]" id="is_active" value="0" {value type='radio' id='top5' default='0' selected='true'} /> No</label>
						</div>
					</div>				
					

					
					
					<div class="control-group">
						<label class="control-label" for="">Views: <span id="value-views"><strong>{$aForms.views}</strong></span> <a href="#" id="show-views">Edit</a></label>
						<div class="controls" id="show-opt-views">
							<input type="hidden" name="site_views" value="2" />
							<input type="text" name="val[views]" id="site_views_input" value="{value type='input' id='views'}" size="10" class="bigger span4" />
						</div>
					</div>

					<div class="control-group">
						<label class="control-label" for="">Like: <span id="value-likes"><strong>{$aForms.likes}</strong></span> <a href="#" id="show-likes">Edit</a></label>
						<div class="controls" id="show-opt-likes" style="display:none;">
							<input type="hidden" name="site_views" value="2" />
							<input type="text" name="val[likes]" id="site_views_input" value="{value type='input' id='likes'}" size="10" class="bigger span4" />
						</div>
					</div>
					
					<div class="control-group">
						<label class="control-label" for="">DisLike: <span id="value-dislikes"><strong>{$aForms.dislikes}</strong></span> <a href="#" id="show-dislikes">Edit</a></label>
						<div class="controls" id="show-opt-dislikes" style="display:none;">
							<input type="hidden" name="site_views" value="2" />
							<input type="text" name="val[dislikes]" id="site_views_input" value="{value type='input' id='dislikes'}" size="10" class="bigger span4" />
						</div>
					</div>					
					
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
		<div id="stack-controls" class="list-controls">
			<div class="btn-toolbar pull-left">
				<div class="btn-group">
					<a href="{url link='video.trash' id=$aForms.id}" class="btn btn-small btn-danger btn-strong" title="">Move to Trash</a>
				</div>
			</div>
			<div class="btn-toolbar">
				<div class="btn-group">
					<button name="cancel" type="button" value="Cancel" onclick="location.href='{url link='video.index'}'" class="btn btn-small btn-normal btn-strong">Cancel</button>
				</div>
				<div class="btn-group">
					<button name="submit" type="submit" value="Save" class="btn btn-small btn-success btn-strong">Save</button>
				</div>
			</div>
		</div>
	</form>