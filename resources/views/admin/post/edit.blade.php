@extends('layouts.backend.app')
@section('title','add tag')
@push('css')
<!-- Bootstrap Select Css -->
<link href="{{asset('assets/backend/plugins/bootstrap-select/css/bootstrap-select.css')}}" rel="stylesheet" />

@endpush
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>FORM EXAMPLES</h2>
    </div>
    <form action="{{route('admin.post.update', $post->id)}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="row clearfix">

            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Add New Post
                        </h2>

                    </div>
                    <div class="body">

                        <div class="form-group form-float">
                            <div class="form-line">
                                <input type="text" class="form-control" name="title" value="{{$post->title}}">
                                <label class="form-label"> Post Title</label>
                            </div>
                        </div>

                        <label>Profile Image</label>
                        <input type='file' name="image" onchange="readURL(this);" />
                        <img id="blah" src="{{asset('assets/backend/images/post/image.png')}}" height="200" width="200"
                            alt="...." /><br>

                        <div class="form-group">
                            <input type="checkbox" name="status" id="publish" class="filled-in" value="1"
                                {{$post->status==true ? 'checked' :''}}>
                            <label for="publish">publish</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Add New Post
                        </h2>

                    </div>
                    <div class="body">

                        <div class="form-group form-float">
                            <div class="form-line  {{$errors->has('categories') ? 'focused error' : ' '}}">
                                <label class="category">Select Category</label>
                                <select name="categories[]" id="category" class="form-control show-tick"
                                    data-live-search="true" multiple>
                                    @foreach($categories as $category)
                                    <option @foreach($post->categories as $postCategory)
                                        {{ $postCategory->id == $category->id ? 'selected' : '' }}
                                        @endforeach
                                        value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group form-float">
                            <div class="form-line  {{$errors->has('tags') ? 'focused error' : ' '}}">
                                <label class="category">Select Tag</label>
                                <select name="tags[]" id="tag" class="form-control show-tick" data-live-search="true"
                                    multiple>
                                    @foreach($tags as $tag)
                                    <option @foreach($post->tags as $postTag)
                                        {{ $postTag->id == $tag->id ? 'selected' :'' }}
                                        @endforeach
                                        value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <a type="button" href="{{route('admin.post.index')}}"
                            class="btn btn-danger m-t-15 waves-effect">Back</a>
                        <button type="submit" class="btn btn-primary m-t-15 waves-effect">Submit</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="row clearfix">

            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card">
                    <div class="header">
                        <h2>
                            Body
                        </h2>

                    </div>
                    <div class="body">

                        <div class="form-group form-float">

                        </div class="body">
                        <textarea name="body" id="tinymce">{{$post->body}}</textarea>
                    </div>


                </div>
            </div>
        </div>

</div>
</form>

<!-- #END# Multi Column -->
</div>

@endsection

@push('js')
<!-- Select Plugin Js -->
<script src="{{asset('assets/backend/plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

<!-- TinyMCE -->
<script src="{{asset('assets/backend/plugins/tinymce/tinymce.js')}}"></script>

<script>
    $(function () {

  

    //TinyMCE
    tinymce.init({
        selector: "textarea#tinymce",
        theme: "modern",
        height: 300,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools'
        ],
        toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons',
        image_advtab: true
    });
    tinymce.suffix = ".min";
    tinyMCE.baseURL = '{{asset('assets/backend/plugins/tinymce')}}';
});
</script>

<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush