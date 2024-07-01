@extends('layouts.index')
@section('title', 'View Document '.$document->id)
@section('content')
<div class="col-lg-12">
    <div class="row">
        <div class="col-md-7">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <div class="card-tools">
                        <small class="text-muted">
                            Date Uploaded: <?php echo date("M d, Y", strtotime($document->created_at)) ?>
                        </small>
                    </div>
                </div>
                <div class="card-body">
                    <div class="callout callout-info">
                        <dl>
                            <dt>Title</dt>
                            <dd><?php echo $document->title ?></dd>
                        </dl>
                    </div>
                    <div class="callout callout-info">
                        <dl>
                            <dt>Description</dt>
                            <dd><?php echo html_entity_decode($document->description) ?></dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card card-outline card-primary">
                <div class="card-header">
                    <h3><b>File/s</b></h3>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="alert alert-info px-2 py-1"><i class="fa fa-info-circle"></i> Click the file to download.</div>
                        <div class="row">
                            <?php
                            if (isset($document->file_json) && !empty($document->file_json)) :
                                foreach ($document->list_file as $k => $v) :
                            ?>

                                    <div class="col-sm-3">
                                        <a href="assets/uploads/files/{{$v->hashName}}" download="{{$v->name}}" target="_blank" class="text-white border-rounded file-item p-1" onclick="return confirm('Are you sure to download this file?')">
                                            <span class="img-fluid bg-dark border-rounded px-2 py-2 d-flex justify-content-center align-items-center" style="width: 100px;height: 100px">
                                                <h3 class="bg-dark"><i class="fa fa-download"></i></h3>
                                            </span>
                                            <span class="text-dark">
                                                @if(str_contains($types[$k], "pdf"))
                                                <i class="fas fa-file-pdf"></i>
                                                @elseif(str_contains($types[$k], "doc")||str_contains($types[$k],"word"))
                                                <i class="fas fa-file-word"></i>
                                                @elseif(str_contains($types[$k], "image"))
                                                <i class="far fa-file-image"></i>
                                                @else
                                                <i class="fas fa-file"></i>
                                                @endif
                                                {{$v->name}}
                                                <br />
                                                <span><strong>{{$v->size}} Bytes</strong></span>
                                            </span>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('.file-item').hover(function() {
        $(this).addClass("active")
    })
    $('file-item').mouseout(function() {
        $(this).removeClass("active")
    })
</script>
@stop()