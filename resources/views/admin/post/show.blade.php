@extends('layouts.backend.app')
@section('title','add tag')
@push('css')


@endpush
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>FORM EXAMPLES</h2>
    </div>

    <a type="button" href="{{route('admin.post.index')}}" class="btn btn-danger m-t-15 waves-effect">Back</a>
    @if($post->is_approved == false)
    <button type="button" class="btn btn-success waves-effect pull-right" onclick="approvepost({{ $post->id }})">
        <i class="material-icons">done</i>
        <span>Approve</span>
    </button>
    <form method="post" action="{{ route('admin.post.approve',$post->id) }}" id="approval-form" style="display: none">
        @csrf
        @method('PUT')
    </form>
    @else
    <button type="button" class="btn btn-success pull-right" disabled>
        <i class="material-icons">done</i>
        <span>Approved</span>
    </button>
    @endif
    <div class="row clearfix">

        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        {{$post->title}}
                        <small>posted by <strong><a href="">{{$post->user->name}}</a></strong>on</small>
                        {{-- {{$post->created_at->toFormattedDateString()}} --}}
                    </h2>

                </div>
                <div class="body">

                    {!!$post->body!!}
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header bg-cyan">
                    <h2>
                        categories
                    </h2>

                </div>
                <div class="body">
                    @foreach($post->categories as $category)
                    <span class="label bg-cyan">{{$category->name}}</span>


                    @endforeach

                </div>
            </div>

            <div class="card">
                <div class="header bg-green">
                    <h2>
                        Tags
                    </h2>

                </div>
                <div class="body">
                    @foreach($post->tags as $tag)
                    <span class="label bg-green">{{$tag->name}}</span>


                    @endforeach

                </div>
            </div>

            <div class="card">
                <div class="header">
                    <h2>
                        Feature image
                    </h2>

                </div>
                <div class="body">
                    <img style="width: 250px; height: 150px;" src="/{{$post->image}}" alt="">

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
<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

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
            tinyMCE.baseURL = '{{ asset('assets/backend/plugins/tinymce') }}';
        });
        function approvepost(id) {
        Swal.fire({
  title: 'Are you sure?',
  text: "You want to Approve this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Approve it!'
}).then((result) => {
  if (result.isConfirmed) {
  
      event.preventDefault();
      document.getElementById('approval-form').submit();
 
  }
})
    }
</script>



@endpush