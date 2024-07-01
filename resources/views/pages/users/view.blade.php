@extends('layouts.index')
@section('title' ,'Information of User '.$user->email)
@section('content')
<div class="container-fluid">
    <div class="card card-widget widget-user shadow">
        <div class="widget-user-header bg-dark">
            <h3 class="widget-user-username"><?php echo ucwords($user->full_name) ?></h3>
            <h5 class="widget-user-desc"><?php echo $user->email ?></h5>
        </div>
        <div class="widget-user-image">
            <?php if (empty($user->email) || (!empty($user->email) && !is_file('assets/uploads/' . $user->avatar))) : ?>
                <span class="brand-image img-circle elevation-2 d-flex justify-content-center align-items-center bg-primary text-white font-weight-500" style="width: 90px;height:90px">
                    <h4><?php echo strtoupper(substr($user->firstname, 0, 1) . substr($user->lastname, 0, 1)) ?></h4>
                </span>
            <?php else : ?>
                <img class="img-circle elevation-2" src="assets/uploads/<?php echo $user->avatar ?>" alt="User Avatar">
            <?php endif ?>
        </div>
        <div class="card-footer">
            <div class="container-fluid">
                <dl>
                    <dt>Address</dt>
                    <dd><?php echo $user->address ?></dd>
                </dl>
                <dl>
                    <dt>User Type</dt>
                    <dd>{{$user->type == 1 ? 'Admin' : 'User'}}</dd>
                </dl>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer display p-0 m-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
<style>
    #uni_modal .modal-footer {
        display: none
    }

    #uni_modal .modal-footer.display {
        display: flex
    }
</style>
@stop()