@extends('layouts.index')
@section('title', 'All Users')
@section('content')
<div class="col-lg-12">
	<div class="card card-outline card-success">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="{{route('users.create')}}"><i class="fa fa-plus"></i> Add New User</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Name</th>
						<th>Contact #</th>
						<th>Role</th>
						<th>Email</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
                    @foreach($users as $id => $user)
					<tr>
						<th class="text-center"><?php echo ++$id; ?></th>
						<td><b><?php echo ucwords($user->full_name) ?></b></td>
						<td><b><?php echo $user->contact ?></b></td>
						<td><b>{{ $user->type == 1 ?  'Admin' : 'User' }}</b></td>
						<td><b><?php echo $user->email ?></b></td>
						<td class="text-center">
							<button type="button" class="btn btn-default btn-sm btn-flat border-info wave-effect text-info dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
		                      Action
		                    </button>
		                    <div class="dropdown-menu" style="">
		                      <a class="dropdown-item view_user" href="{{route('users.show',$user->id)}}" data-id="<?php echo $user->id ?>">View</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item" href="{{route('users.edit', $user->id)}}">Edit</a>
		                      <div class="dropdown-divider"></div>
		                      <a class="dropdown-item delete_user" href="{{route('users.destroy',$user->id)}}" onclick="return confirm('Deleting this user?');" data-id="<?php echo $user->id ?>">Delete</a>
		                    </div>
						</td>
					</tr>
                    @endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>

@stop()