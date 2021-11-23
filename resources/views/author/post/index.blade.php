@extends('layouts.backend.app')
@push('css')
<link href="{{asset('assets/backend/plugins/jquery-datatable/skin/bootstrap/css/dataTables.bootstrap.css')}}"
    rel="stylesheet">

@endpush

@section('content')
<div class="container-fluid">
    <div class="block-header">
        <h2>
            Tag
            <small>Taken from <a href="https://datatables.net/" target="_blank">datatables.net</a></small>
        </h2>
        <a class="margin:right" href="{{route('author.post.create')}}">Add</a>
    </div>
    <!-- Basic Examples -->

    <!-- #END# Basic Examples -->
    <!-- Exportable Table -->
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="header">
                    <h2>
                        Posts
                        <span>{{$posts->count()}}</span>
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
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                            <thead>
                                <tr>
                                    <th>sl</th>
                                    <th>title</th>
                                    <th>user</th>
                                    <th>body</th>
                                    <th>is_approved</th>
                                    <th>status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>

                                    <th>sl</th>
                                    <th>title</th>
                                    <th>user</th>
                                    <th>body</th>
                                    <th>is_approved</th>
                                    <th>status</th>

                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>

                                @php $sl = 1; @endphp
                                @foreach($posts as $post)

                                <tr>
                                    <td>{{$sl++}}</td>
                                    <td>{{str_limit($post->title,'15')}}</td>
                                    <td>{{$post->user->name}}</td>
                                    <td>{{$post->body}}</td>
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
                                        <span class="badge bg-pink">pending</span>

                                        @endif

                                    </td>
                                    <td class="text-center">

                                        <a class="btn btn-sm btn-secondary m-5"
                                            href="{{route('author.post.show',$post->id)}}">
                                            <i class="material-icons">visibility</i>
                                        </a>

                                        <a class="btn btn-sm btn-secondary m-5"
                                            href="{{route('author.post.edit',$post->id)}}">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        {{-- <a class="btn btn-sm btn-secondary m-5"
                                            href="{{route('seller.brand.status',$brand->id)}}">
                                            <i
                                                class="fa fa-refresh mr-5 {{$brand->status == 1 ? 'text-success' :' text-warning'}}"></i>
                                            Status
                                        </a> --}}
                                        <button class="btn btn-danger" type="button"
                                            onclick="deletePost({{$post->id}})">
                                            <i class="material-icons">delete</i>
                                        </button>
                                        <form id="delete-form-{{$post->id}}"
                                            action="{{route('author.post.destroy', $post->id)}}" method="post">
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

<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/jszip.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/pdfmake.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/vfs_fonts.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/backend/plugins/jquery-datatable/extensions/export/buttons.print.min.js') }}"></script>

<script src="{{ asset('assets/Backend/js/pages/tables/jquery-datatable.js') }}"></script>
<script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    function deletePost(id) {
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
</script>
@endpush