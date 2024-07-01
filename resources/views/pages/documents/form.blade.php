@extends('layouts.index')
@section('title', $title)
@section('content')
<div class="col-lg-12">
    <div class="card card-outline card-primary">
        <div class="card-body">
            <form action="" id="manage-upload" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id" value="<?php echo isset($id) ? $id : '' ?>">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="title" class="control-label">Title</label>
                            <input type="text" id="title" class="form-control form-control-sm" name="title" value="<?php echo isset($document) ? $document->title : '' ?>">
                            @error('title')
                            <small class="help-block">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-10">
                        <div class="form-group">
                            <label for="description" class="control-label">Description</label>
                            <textarea name="description" id="description" cols="30" rows="10" class="summernote form-control">
								<?php echo isset($document) ? $document->description : '' ?>
							</textarea>
                            @error('description')
                            <small class="help-block">{{$message}}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                <!-- <div id="f-inputs" class="d-none"></div> -->
                <div class="btn-group w-100" id="upload_btns">
                    <label for="files" class="btn btn-success btn-flat col-sm-4 col fileinput-button dz-clickable">
                        <i class="fas fa-plus"></i>
                        <span>Add files</span>
                    </label>
                </div>
                <input type="file" id="files" name="myfile[]" multiple style="display: none;" onchange="showFiles(this)">
                @error('myfile')
                <small class="help-block">{{$message}}</small>
                @enderror
                @if(isset($document))
                <div class="d-flex align-items-center justify-content-center text-red text-bold">
                    Orginal files
                </div>
                <div class="row mt-2 dz-processing dz-success dz-complete">
                    @foreach($document->list_file as $key=>$file)
                    <div class="col d-flex align-items-center">
                        <p class="mb-0">
                            <a class="lead" href="assets/uploads/files/{{$file->hashName}}" download="{{$file->name}}" onclick="return confirm('Are you sure to download this file?')">
                                @if(str_contains($types[$key], "pdf"))
                                <i class="fas fa-file-pdf"></i>
                                @elseif(str_contains($types[$key], "doc")||str_contains($types[$key],"word"))
                                <i class="fas fa-file-word"></i>
                                @elseif(str_contains($types[$key], "image"))
                                <i class="far fa-file-image"></i>
                                @else
                                <i class="fas fa-file"></i>
                                @endif
                                {{$file->name}}
                            </a>
                            <br />
                            <span><strong>{{$file->size}} Bytes</strong></span>
                        </p>
                    </div>
                    @endforeach
                </div>
                @endif
                <div class="d-flex align-items-center justify-content-center text-red text-bold">
                    Your selected files:
                </div>
                <div class="row mt-2 dz-processing dz-success dz-complete" id="my_files">
                </div>
        </div>
    </div>
    <div class="card-footer border-top border-info">
        <div class="d-flex w-100 justify-content-center align-items-center">
            <button class="btn btn-flat  bg-gradient-primary mx-2" type="submit">Save</button>
            <a class="btn btn-flat bg-gradient-secondary mx-2" href="{{route('documents.index')}}">Cancel</a>
        </div>
    </div>
    </form>
</div>
</div>
<script>
    const showFiles = (input) => {
        if (input.files && input.files.length) {
            var _html = '';
            var _icon = '';
            for (let i = 0; i < input.files.length; i++) {
                var file = input.files[i]
                var reader = new FileReader();
                reader.onload = function(e) {
                    if (input.files[i].type.includes("pdf")) {
                        _icon = `<i class="fas fa-file-pdf"></i>`
                    } else if (input.files[i].type.includes("word") || input.files[i].type.includes("doc")) {
                        _icon = `<i class="fas fa-file-word"></i>`
                    } else if (input.files[i].type.includes("image")) {
                        _icon = `<i class="far fa-file-image"></i>`
                    } else {
                        _icon = `<i class="fas fa-file"></i>`
                    }
                    _html += `
                    <div class="col d-flex align-items-center">
                        <p class="mb-0">
                            <a class="lead" href="${e.target.result}" target="blank" download="${input.files[i].name}">
                                ` + _icon + `${input.files[i].name}
                            </a>
                            <br/>
                            <span><strong>${input.files[i].size} Bytes</strong></span>
                        </p>
                    </div>
                `;
                    document.querySelector("#my_files").innerHTML = _html
                }
                reader.readAsDataURL(file);
            }
        }
    }
</script>
@stop()