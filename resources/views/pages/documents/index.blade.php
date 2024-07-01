@extends('layouts.index')
@section('title', 'All Documents')
@section('content')
<div class="col-lg-12">
	<div class="card card-outline card-primary">
		<div class="card-header">
			<div class="card-tools">
				<a class="btn btn-block btn-sm btn-default btn-flat border-primary" href="{{route('documents.create')}}"><i class="fa fa-plus"></i> Add New</a>
			</div>
		</div>
		<div class="card-body">
			<table class="table tabe-hover table-bordered" id="list">
				<?php if (auth('my_sys')->user()->type == 1) : ?>
					<colgroup>
						<col width="10%">
						<col width="25%">
						<col width="35%">
						<col width="20%">
						<col width="10%">
					</colgroup>
				<?php else : ?>
					<colgroup>
						<col width="10%">
						<col width="30%">
						<col width="50%">
						<col width="10%">
					</colgroup>
				<?php endif; ?>

				<thead>
					<tr>
						<th class="text-center">#</th>
						<th>Title</th>
						<th>Description</th>
						<?php if (auth('my_sys')->user()->type == 1) : ?>
							<th>User</th>
						<?php endif; ?>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$i = 1;
					foreach ($docs as $row) :
						$trans = get_html_translation_table(HTML_ENTITIES, ENT_QUOTES);
						unset($trans["\""], $trans["<"], $trans[">"], $trans["<h2"]);
						$desc = strtr(html_entity_decode($row['description']), $trans);
						$desc = str_replace(array("<li>", "</li>"), array("", ", "), $desc);
					?>
						<tr>
							<th class="text-center"><?php echo $i++ ?></th>
							<td><b><?php echo ucwords($row['title']) ?></b></td>
							<td><b class="truncate"><?php echo strip_tags($desc) ?></b></td>
							<?php if (auth('my_sys')->user()->type == 1) : ?>
								<td><?php echo isset($row->user_id) ? $row->user_name : "Deleted User" ?></td>
							<?php endif; ?>
							<td class="text-center">

								<div class="btn-group">
									<a href="{{route('documents.edit', $row->id)}}" class="btn btn-primary btn-flat">
										<i class="fas fa-edit"></i>
									</a>
									<a href="{{route('documents.show', $row->id)}}" class="btn btn-info btn-flat">
										<i class="fas fa-eye"></i>
									</a>
									<a class="btn btn-danger btn-flat delete_document" href="{{route('documents.destroy', $row->id)}}" onclick="return confirm('Are you sure to delete this upload?')">
										<i class="fas fa-trash"></i>
									</a>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
</div>
@stop()