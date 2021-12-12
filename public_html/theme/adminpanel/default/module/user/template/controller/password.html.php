    <div class="content">
	<h2>Update Password</h2>		
	{error}
	<table width="100%" border="0" cellspacing="2" cellpadding="5">
      <tr>
        <td>
        <form name="register-form" method="post" action="{url link='user.password'}" class="form-horizontal">
			<div class="control-group">
			<label class="control-label">Current Password</label>
			<div class="controls">
				<input name="val[old_password]" type="password" maxlength="32" />
			</div>
			</div>
        
			<div class="control-group">
			<label class="control-label">New Password</label>
			<div class="controls">
				<input name="val[new_password]" type="password" maxlength="32" />
			</div>
			</div>			
			
			
			
			<div class="control-group">
			<label class="control-label">Confirm Password</label>
			<div class="controls">
				<input name="val[confirm_password]" type="password" maxlength="32" />
			</div>
			</div>
			
			
			<div class="control-group">
			<div class="controls">
				<input type="submit" name="submit" value="Update password" class="btn btn-success" />
			</div>
			</div>
        </form>
        </td>
        </tr>
    </table>
    </div><!-- .content -->