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