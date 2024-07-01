@extends('layouts.index')
@section('title', 'Home')
@section('content')
<?php if (auth('my_sys')->user()->type == 1) : ?>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Users</span>
                    <span class="info-box-number">
                        {{$users->count()}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-folder"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Documents</span>
                    <span class="info-box-number">
                        {{$documents->count()}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
    </div>

<?php else : ?>
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                Welcome <?php echo auth('my_sys')->user()->firstname ?>!
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-folder"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Documents</span>
                    <span class="info-box-number">
                        {{$documents->count()}}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

<?php endif; ?>

@stop()