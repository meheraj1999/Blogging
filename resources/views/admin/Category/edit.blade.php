@extends('layouts.backend.app')
@section('title','add tag')
@push('css')

@endpush
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>FORM EXAMPLES</h2>
    </div>

    <!-- Vertical Layout -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Edit Tag
                    </h2>
                    <ul class="header-dropdown m-r--5">
                        <li class="dropdown">
                            <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="material-icons">more_vert</i>
                            </a>
                            <ul class="dropdown-menu pull-right">
                                <li><a href="javascript:void(0);">Action</a></li>
                                <li><a href="javascript:void(0);">Another action</a></li>
                                <li><a href="javascript:void(0);">Something else here</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
                <div class="body">
                    <form action="{{route('admin.category.update', $cat->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="name" value="{{$cat->name}}">
                                <label class="form-label"> Tag Name</label>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12" for="example-file-input">category Image</label>
                            <div class="col-12">

                                <center>
                                    <div class="fileinput-new thumbnail" style="height: 100px; width:200px">
                                        <img id="previmage" src="/{{$cat->image }}" width="200" height="100">

                                        {{-- <img id="previmage" src="{{$cat->image ? '/' . $cat->image :
                                        '/assets/images/album-image-1.jpg'}}" width="200" height="100"> --}}

                                    </div>
                                </center>
                                <label for="profile_photo" class="control-label">category Image*</label>
                                <input type="file" class="form-control" id="previmage" value="/{{ $cat->image }}"
                                    name="image" onchange="readURL(this);">


                            </div>
                        </div>




                        <a type="button" href="{{route('admin.category.index')}}"
                            class="btn btn-danger m-t-15 waves-effect">Back</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- #END# Multi Column -->
</div>

@endsection

@push('js')
<Script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#previmage')
                    .attr('src', e.target.result)
                    .width(140)
                    .height(140);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</Script>
@endpush