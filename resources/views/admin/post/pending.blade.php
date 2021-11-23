@extends('layouts.backend.app')
@push('css')
<link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}"
    rel="stylesheettag">
@endpush
@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>
            <a class="btn btn-primary" href="{{route('admin.post.create')}}">Add new</a>
            <i class="material-icons"></i>
            <span>Add new</span>
        </h2>
    </div>
    <!-- Basic Examples -->

    <!-- #END# Basic Examples -->
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        EXPORTABLE TABLE
                        <span class="badge bg-blue">{{$posts->count()}}</span>
                    </h2>

                </div>
                <div class="body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th><i class="material-icons">visibility</i></th>
                                    <th>Is Approved</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Sl</th>
                                    <th>Title</th>
                                    <th>Author</th>
                                    <th><i class="material-icons">visibility</i></th>
                                    <th>Is Approved</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                @foreach($posts as $key=>$post)

                                <tr>
                                    <td>{{ $key +1}}</td>
                                    <td>{{ $post->title}}</td>
                                    <td>{{ $post->user->name}}</td>
                                    <td>{{ $post->view_count}}</td>

                                    <td>
                                        @if($post->is_approved==true)
                                        <span class="badge bg-blue">Approved</span>
                                        @else
                                        <span class="badge bg-red">pending</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($post->status==true)
                                        <span class="badge bg-blue">published</span>
                                        @else
                                        <span class="badge bg-red">pending</span>
                                        @endif
                                    </td>


                                    <td>

                                        @if($post->is_approved == false)
                                        <button type="button" class="btn btn-success waves-effect"
                                            onclick="approvepost({{ $post->id }})">
                                            <i class="material-icons">done</i>

                                        </button>
                                        <form method="post" action="{{ route('admin.post.approve',$post->id) }}"
                                            id="approval-form" style="display: none">
                                            @csrf
                                            @method('PUT')
                                        </form>

                                        @endif

                                        <a href="{{route('admin.post.show', $post->id)}}" class="btn btn-green">
                                            <i class="material-icons">visibility</i>

                                        </a>


                                        <a href="{{route('admin.post.edit', $post->id)}}" class="btn btn-info">
                                            <i class="material-icons">edit</i>

                                        </a>
                                        <button class="btn btn-danger" type="button"
                                            onclick="deletepost({{$post->id}})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <form id="delete-form-{{$post->id}}"
                                            action="{{route('admin.post.destroy', $post->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- #END# Exportable Table -->
</div>

@endsection

@push('js')
<script src="{{ asset('assets/backend/plugins/jquery-datatable/jquery.dataTables.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/js/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/dataTables.buttons.min.js') }}">
</script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

<script src="{{ asset('assets/backend/js/pages/tables/jquery-datatable.js') }}"></script>
<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    function deletepost(id) {
        Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
  if (result.isConfirmed) {
  
      event.preventDefault();
      document.getElementById('delete-form-'+id).submit();
 
  }
})
    }

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