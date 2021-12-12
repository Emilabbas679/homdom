<div class="content">
	
	<div class="entry-count">
		<ul class="pageControls">
			<li>
			<div class="floatL">
				<strong class="blue">{$aVideoCount}</strong><span>videos</span>
			</div>
			<div class="blueImg">
				<div class="pm-sprite ico-videos-small">
				</div>
			</div>
			</li>
		</ul>
		<!-- .pageControls -->
	</div>
	<h2>Videos <a class="label opac5" href="{url link='video.add'}" data-toggle="modal">+ add new</a></h2>
	<div id="video_check_message" class="alert alert-info" style="display: none;"></div>
	<div class="pull-left"></div>
	<div class="clearfix"></div>
	<form name="video_index" action="{url link='video.index'}" method="GET" class="form-search-listing form-inline">
		<div class="row-fluid">
			<div class="span8">
				<ul class="pm-inline-filters list-inline">
					<li><a href="{url link='video.index'}">All videos</a><a href="{url link='video.index'}" class="remove-filter">&times;</a></li>
				</ul>
			</div>
			<!-- .span8 -->
			<div class="span4">
				<div class="pull-right">
					<label><small>Videos/page</small></label>
					<select name="val[iPageSize]" class="smaller-select" >
						<option value="25" {if $iPageSize == 25 } selected="selected" {/if}>25</option>
						<option value="50" {if $iPageSize == 50 } selected="selected" {/if}>50</option>
						<option value="75" {if $iPageSize == 75 } selected="selected" {/if}>75</option>
						<option value="100" {if $iPageSize == 100 } selected="selected" {/if}>100</option>
						<option value="125" {if $iPageSize == 125 } selected="selected" {/if}>125</option>
					</select>
				</div>
			</div>
		</div>
		<!-- .row-fluid-->
		<div class="tablename">
			<div class="row-fluid">
				<div class="span8">
					<div class="qsFilter pull-left">
						<div class="btn-group input-prepend">
							<div class="form-filter-inline">
									<button type="button" id="appendedInputButtons" class="btn">Filter</button>
									
									<select name='val[language_id]' id='main_select_language must' class='main_select_language span12' > 
									<option value="">by dillər ...</option>
									{foreach from=$aLanguages item=aLanguage} 
									<option value="{$aLanguage.language_id}"{value type='select' id='language_id' default=$aLanguage.language_id}>{$aLanguage.title}</option> {/foreach} </select>

									<select name="val[type]">
										<option value="0">by videos ...</option>
										{foreach from=$aVideosType key=VideosTypeKey item=VideosTypeName}
											<option value="{$VideosTypeKey}"{value type='select' id='type' default=$VideosTypeKey}>{$VideosTypeName}</option>
										{/foreach}
									</select>
									<select name='val[category_id]' id='select_move_to_category' class='inline last-filter'><option value=''>by category..</option>{$aCategories}</select>
							</div>
							<!-- .form-filter-inline -->
						</div>
						<!-- .btn-group -->
					</div>
					<!-- .qsFilter -->
				</div>
				<div class="span4">
					<div class="pull-right">
						<div class="input-append">
							<input name="val[keywords]" type="text" value="" size="30" class="search-query search-quez input-medium" placeholder="Enter keyword" id="form-search-input"/>
							<select name="val[keywords]" class="input-small">
								<option value="video_title">Title</option>
							</select>
							<button type="submit" name="submit" class="btn" value="Search" id="submitFind" onsubmit="this.form.submit()">
								<i class="icon-search findIcon"></i>
								<span class="findLoader"><img src="img/ico-loading.gif" width="16" height="16"/></span>
							</button>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</form>
	<div class="clearfix"></div>
	
	{error}
	<form name="videos_checkboxes" id="videos_checkboxes" action="#" method="post">
		<table cellpadding="0" cellspacing="0" width="100%" class="table table-striped table-bordered pm-tables tablesorter">
			<thead>
				<tr>
					<th align="center" style="text-align:center" width="3%">
						<input type="checkbox" name="checkall" id="selectall" onclick="checkUncheckAll(this);"/>
					</th>
					<th width="5%">
						ID
					</th>
					<th width="3%">
						Status
					</th>
					<th width="3%">
						Language
					</th>
					<th width="3%">
						Photo
					</th>
					<th width="300">
						Video title
					</th>					
					<th width="2">
						PlayTime
					</th>					
					<th width="2">
						Filesize
					</th>
					<th width="90">
						Added
					</th>
					<th width="65">
						Views
					</th>
					<th width="190">
						Category
					</th>
					<th style="width: 90px;">
						Action
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="tablePagination">
					<td colspan="11" class="tableFooter">{pager}</td>
				</tr>
				{foreach from=$aVideos key=iKey item=aRow}
				<tr class="" data-uniq-id="470d6da3b" data-video-id="{$aRow.id}">
					<td align="center" style="text-align:center" width="3%">
						<input name="video_ids[]" type="checkbox" value="{$aRow.id}" id="{$aRow.id}"/>
					</td>
					<td align="center" style="text-align:center">
						{$aRow.id}
					</td>
					<td align="center" style="text-align:center; width: 12px;">
						<div class="pm-sprite {if $aRow.is_active == 1}vs_ok{else}vs_unchecked{/if} opac7" id="status_{$aRow.id}" alt="" rel="tooltip" title="Video status: {if $aRow.is_active == 1}active{else}deactive{/if}">
						</div>
					</td>
					<td>
						<small>{$aRow.language_id}</small>
					</td>					
					<td>
						<small><img src="{img path='video.url_pic' file=$aRow.pic size='50x50'}" id="must" style="display:block;min-width:50px;width:50px;min-height:50px; no-repeat center center;"/></small>
					</td>
					<td>
						<span style="visibility:hidden; display:none;">{$aRow.title}</span>
							<a href="/?{$aRow.id}" target="blank">{$aRow.title}</a>
						<div class="pull-right">
						</div>
					</td>
					
					<td>
						<?=gmdate('H:i:s', $this->_aVars['aRow']['seconds'])?>
					</td>
					<td>
						<?=AIN::getLib('file')->filesize($this->_aVars['aRow']['filesize'])?>
					</td>
					
					
					<td align="center" style="text-align:center">
						<span style="font-size:0.1pt; position:absolute; color:#fff; display:none;">{$aRow.added}</span>
						<span rel="tooltip" title="<?php echo date("M d, Y g:i A", $this->_aVars['aRow']['added'] );?>"><?php echo date("M d, Y", $this->_aVars['aRow']['added'] );?></span>
					</td>
					<td align="center" style="text-align:center">
						{$aRow.views}
					</td>
					<td>
						<a href="{url link='current' val[category_id]=$aRow.category_id}" rel="tooltip" title="List videos from <?=AIN::getService('video.categories')->get_row($this->_aVars['aRow']['category_id'],'name')?> only"><?=AIN::getService('video.categories')->get_row($this->_aVars['aRow']['category_id'],'name')?></a>
					</td>
					<td align="center" class="table-col-action" style="text-align:center">
						<a href="{url link='video.add' id=$aRow.id}" class="btn btn-mini btn-link" rel="tooltip" title="Edit video"><i class="icon-pencil"></i></a>
					</td>
				</tr>
				{/foreach}		
				<tr class="tablePagination">
					<td colspan="11" class="tableFooter">{pager}</td>
				</tr>
			</tbody>
		</table>
		<div class="clearfix"></div>		
		<div id="stack-controls" class="list-controls">		
			<div class="btn-toolbar">
				<div class="btn-group">
					<button type="submit" name="VideoChecker" id="VideoChecker" value="Check status" class="btn btn-small btn-success btn-strong" onclick="javascript: return false;">Aktiv</button>
				</div>
				<div class="btn-group">
					<button type="submit" name="VideoDeactive" id="VideoDeactive" value="Deactivve status" class="btn btn-small btn-warning btn-strong" onclick="javascript: return false;">DeAktiv</button>
				</div>
				
				
				
			</div>
		</div>
	</form>
</div> 
<!-- .content -->