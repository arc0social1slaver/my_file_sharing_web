@extends('layouts.index')
@section('title', $title)
@section('content')
<div class="col-lg-12">
	<div class="card">
		<div class="card-body">
			<form action="" id="manage_user" method="post" enctype="multipart/form-data">
                @csrf
				<input type="hidden" name="id" value="<?php echo isset($user) ? $user->id : '' ?>">
				<div class="row">
					<div class="col-md-6 border-right">
						<b class="text-muted">Personal Information</b>
						<div class="form-group">
							<label for="firstname" class="control-label">First Name</label>
							<input type="text" name="firstname" id="firstname" class="form-control form-control-sm" required value="<?php echo isset($user) ? $user->firstname : '' ?>">
							@error('firstname')
								<small class="help-block">{{$message}}</small>
							@enderror
						</div>
						<div class="form-group">
							<label for="middlename" class="control-label">Middle Name</label>
							<input type="text" name="middlename" id="middlename" class="form-control form-control-sm"  value="<?php echo isset($user) ? $user->middlename : '' ?>">
							@error('middlename')
								<small class="help-block">{{$message}}</small>
							@enderror
						</div>
						<div class="form-group">
							<label for="lastname" class="control-label">Last Name</label>
							<input type="text" name="lastname" id="lastname" class="form-control form-control-sm" required value="<?php echo isset($user) ? $user->lastname : '' ?>">
							@error('lastname')
								<small class="help-block">{{$message}}</small>
							@enderror
						</div>
						<div class="form-group">
							<label for="contact" class="control-label">Contact No.</label>
							<input type="text" name="contact" id="contact" class="form-control form-control-sm" required value="<?php echo isset($user) ? $user->contact : '' ?>">
							@error('contact')
								<small class="help-block">{{$message}}</small>
							@enderror
						</div>
						<div class="form-group">
							<label class="control-label" for="address">Address</label>
							<textarea name="address" id="address" cols="30" rows="4" class="form-control"><?php echo isset($user) ? $user->address : '' ?></textarea>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<label for="customFile" class="control-label">Avatar</label>
							<div class="custom-file">
		                      <input type="file" class="custom-file-input" id="customFile" name="img" onchange="displayImg(this,$(this))">
		                      <label class="custom-file-label" for="customFile">Choose file</label>
		                    </div>
							@error('img')
								<small class="help-block">{{$message}}</small>
							@enderror
						</div>
						<div class="form-group d-flex justify-content-center">
							<img src="<?php echo isset($user) ? 'assets/uploads/'.$user->avatar :'' ?>" alt="" id="cimg" class="img-fluid img-thumbnail">
						</div>
						<b class="text-muted">System Credentials</b>
						<?php if(auth('my_sys')->user()->type == 1): ?>
						<div class="form-group">
							<label for="type" class="control-label">User Role</label>
							<select name="type" id="type" class="custom-select custom-select-sm">
								<option value="2" <?php echo isset($user) && $user->type == 2 ? 'selected' : '' ?>>User</option>
								<option value="1" <?php echo isset($user) && $user->type == 1 ? 'selected' : '' ?>>Admin</option>
							</select>
						</div>
						<?php else: ?>
							<input type="hidden" name="type" value="3">
						<?php endif; ?>
						<div class="form-group">
							<label class="control-label" for="email">Email</label>
							<input type="email" id="email" class="form-control form-control-sm" name="email" required value="<?php echo isset($user) ? $user->email : '' ?>">
							<small id="#msg"></small>
							@error('email')
								<small class="help-block">{{$message}}</small>
							@enderror
						</div>
						<div class="form-group">
							<label class="control-label" for="password">Password</label>
							<input type="password" id="password" class="form-control form-control-sm" name="password" <?php echo isset($user) ? "":'required' ?>>
							<small><i><?php echo isset($user) ? "Leave this blank if you dont want to change you password":'' ?></i></small>
							@error('password')
								<small class="help-block">{{$message}}</small>
							@enderror
						</div>
						<div class="form-group">
							<label class="label control-label" for="cpass">Confirm Password</label>
							<input type="password" id="cpass" class="form-control form-control-sm" name="cpass" <?php echo isset($user) ? "":'required' ?>>
							<small><i><?php echo isset($user) ? "Leave this blank as well if you dont want to change you password":'' ?></i></small>
							<br>
							<small id="pass_match" data-status=''></small>
							@error('cpass')
								<small class="help-block">{{$message}}</small>
							@enderror
						</div>
					</div>
				</div>
				<hr>
				<div class="col-lg-12 text-right justify-content-center d-flex">
					<button class="btn btn-primary mr-2" type="submit">Save</button>
					<button class="btn btn-secondary" type="button" onclick="location.href = '{{route("users.index")}}'">Cancel</button>
				</div>
			</form>
		</div>
	</div>
</div>
<style>
	img#cimg{
		max-height: 15vh;
		/*max-width: 6vw;*/
	}
</style>
<script>
    function displayImg(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cimg').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>
@stop()