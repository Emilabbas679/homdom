{{if isset($aPager) && $aPager.totalPages > 1}}
<div class="pagination">
<ul>

	{{if isset($aPager.prevUrl)}}
		<li><a href="{{$aPager.prevUrl}}" ></a></li>
    {{ else }}
        <li><a href="javascript:void(0)"></a></li>
    {{/if}}
	
	{{foreach from=$aPager.urls key=sLink name=pager item=sPage}}
		<li class=" "><a href="{{$sLink}}" class="{{if $aPager.current == $sPage}} active_pagin {{/if}}">{{$sPage}}</a></li>
	{{/foreach}}
	
	{{if isset($aPager.nextUrl)}}
		<li><a href="{{$aPager.nextUrl}}" ></a></li>
    {{ else }}
        <li><a href="javascript:void(0)"></a></li>
	{{/if}}


</ul>
</div>
{{/if}}

