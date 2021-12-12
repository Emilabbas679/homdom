{{if $sPublicMessage}}
<div class="public_message alert alert-info" id="public_message">
	{{$sPublicMessage}}
</div>
<script type="text/javascript">
	$Behavior.theme_admincp_error = function()
	{{l}}
		$('#public_message').show();
	{{r}};
</script>
{{/if}}


<div id="core_js_messages">
{{if count($aErrors)}}
{{foreach from=$aErrors item=sErrorMessage}}
	<div class="error_message alert alert-error animated flash">{{$sErrorMessage}}</div>
{{/foreach}}
{{unset var=$sErrorMessage var2=$sample}}
{{/if}}
</div>