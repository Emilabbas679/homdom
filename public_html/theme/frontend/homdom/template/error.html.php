{{if $sPublicMessage && !is_bool($sPublicMessage)}}
<div class="public_message" id="public_message">
    {{$sPublicMessage}}
</div>
<script type="text/javascript">
    $Behavior.template_error = function()
    {{l}}
    $('#public_message').show();
    {{r}};
</script>
{{/if}}


<div id="pem"><a name="pem"></a></div>

<div id="core_js_messages">
    {{if count($aErrors)}}
    {{foreach from=$aErrors item=sErrorMessage}}
    <div class="error_message">{{$sErrorMessage}}</div>
    {{/foreach}}
    {{unset var=$sErrorMessage var2=$sample}}
    {{/if}}
</div>