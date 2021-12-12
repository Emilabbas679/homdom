{{if isset($aPager) && $aPager.totalPages > 1}}
<div class="pagination pull-right">
    <ul>
        {{if isset($aPager.firstUrl)}}<li class="first"><a {{if $sAjax}}href="{{$aPager.firstUrl}}"
                onclick="$(this).parent().parent().parent().parent().find('.sJsPagerDisplayCount').html($.ajaxProcess('{{phrase var='homdom.loading'}}')); $.ajaxCall('{{$sAjax}}', 'page={{$aPager.firstAjaxUrl}}{{$aPager.sParams}}'); $homdom.addUrlPager(this); return false;"
                {{else}}href="{{$aPager.firstUrl}}" {{/if}}>{{phrase var='homdom.first' }}</a> </li>{{/if}} {{if
                isset($aPager.prevUrl)}}<li><a href='{{$aPager.prevUrl}}'><i class="fa fa-arrow-left"></i></a></li>{{/if}}
        {{foreach from=$aPager.urls key=sLink name=pager item=sPage}}
        <li {{if $aPager.current==$sPage}} class="active" {{/if}}><a href="{{$sLink}}">{{$sPage}}</a></li>
        {{/foreach}}
        {{if isset($aPager.lastUrl)}}<li><a href="{{$aPager.nextUrl}}"><i class="fa fa-arrow-right"></i></a></li>{{/if}}
        {{if isset($aPager.lastUrl)}}<li><a {{if $sAjax}}href="{{$aPager.lastUrl}}"
                onclick="$(this).parent().parent().parent().parent().find('.sJsPagerDisplayCount').html($.ajaxProcess('{{phrase var='homdom.loading'}}')); $.ajaxCall('{{$sAjax}}', 'page={{$aPager.lastAjaxUrl}}{{$aPager.sParams}}'); $homdom.addUrlPager(this); return false;"
                {{else}}href="{{$aPager.lastUrl}}" {{/if}}>{{phrase var='homdom.last' }}</a> </li>{{/if}} </ul> </div> {{/if}}