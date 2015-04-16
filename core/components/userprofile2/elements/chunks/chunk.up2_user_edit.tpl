<form action="" method="post" class="form-horizontal well" id="up2-user-edit" enctype="multipart/form-data">
	<div class="header">
		<small>[[%up2_edit_header]]</small>
	</div>

	<input type="hidden" name="id" value="[[+id]]" />
	<input type="hidden" name="type" value="[[+type]]" />
	<input type="hidden" name="removephoto" value="" />
	<div class="form-group avatar">
		<label class="col-sm-3 control-label">[[%up2_avatar]]</label>
		<div class="col-sm-9">
			<img src="[[+avatar]]" id="up2-avatar" data-gravatar="[[+gravatar]]" width="100" />
			<a href="#" id="up2-remove-avatar" [[+photo:is=``:then=`style="display:none;"`]]">
				[[%up2_remove_avatar]]
				<i class="glyphicon glyphicon-remove"></i>
			</a>
			<p class="help-block">[[%up2_avatar_desc]]</p>
			<input type="file" name="photo" value="[[+photo]]" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">[[%up2_username]]<sup class="red">*</sup></label>
		<div class="col-sm-9">
			<input type="text" name="username" value="[[+username]]" placeholder="[[%up2_username]]"  class="form-control" />
			<p class="help-block message">[[+error_username]]</p>
			<p class="help-block desc">[[%up2_username_desc]]</p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">[[%up2_fullname]]<sup class="red">*</sup></label>
		<div class="col-sm-9">
			<input type="text" name="fullname" value="[[+fullname]]" placeholder="[[%up2_fullname]]" class="form-control" />
			<p class="help-block message">[[+error_fullname]]</p>
			<p class="help-block desc">[[%up2_fullname_desc]]</p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">[[%up2_email]]<sup class="red">*</sup></label>
		<div class="col-sm-9">
			<input type="text" name="email" value="[[+email]]" placeholder="[[%up2_email]]" class="form-control" />
			<p class="help-block message">[[+error_email]]</p>
			<p class="help-block desc">[[%up2_email_desc]]</p>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-3 control-label">[[%up2_password]]</label>
		<div class="col-sm-9">
			<input type="password" name="specifiedpassword" value="" placeholder="********" class="form-control" />
			<p class="help-block message">[[+error_specifiedpassword]]</p>
			<p class="help-block desc">[[%up2_specifiedpassword_desc]]</p>
			<input type="password" name="confirmpassword" value="" placeholder="********" class="form-control" />
			<p class="help-block message">[[+error_confirmpassword]]</p>
			<p class="help-block desc">[[%up2_confirmpassword_desc]]</p>
		</div>
	</div>
	<hr/>

	[[+tabs]]

	<div class="form-group">
		<div class="col-sm-offset-3 col-sm-9">
			<button type="submit" class="btn btn-primary">[[%up2_save_profile]]</button>
			&nbsp;&nbsp;&nbsp;&nbsp;
			<a class="btn btn-danger" href="/?action=auth/logout">[[%up2_logout_profile]]</a>
		</div>
	</div>
</form>