		<!-- Here goes the content. -->
		<section id="content" class="container_12 clearfix" data-sort=true>
			<div class="grid_12">
				<div class="box">				
					<div class="header">
						<h2><img class="icon" src="img/icons/packs/fugue/16x16/table.png">DİLLƏR</h2>
					</div>					
					<div class="content">
						{error}
						<form action="{url link='language'}" class="box" method="POST" enctype="multipart/form-data">
							<table class="styled"> 
							<thead>
								<tr>
									<th style="width: 5px;">id</th>
									<th style="width: 5px;">Language</th>
									<th style="width: 80px !important;">Alətlər</th>
								</tr>
							</thead>
								{foreach from=$aLanguages key=iKey item=aLanguage}
								<tr>
									<td style="width: 5px;">{$aLanguage.language_id}</td>
									<td>{$aLanguage.title}</td>
									<td class="center">
										<a href="{url link='language.add' id=$aLanguage.language_id}" class="button small grey tooltip" data-gravity="s" title="{phrase var='core.edit'}"><i class="icon-pencil"></i></a>
									</td>
								</tr>
								{/foreach}							
							</table>							
						</form>
						{pager}
					</div><!-- End of .content -->					
				</div><!-- End of .box -->
			</div><!-- End of .grid_12 -->			
		</section><!-- End of #content -->		