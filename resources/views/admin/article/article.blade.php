@extends('admin.app')
@push('css')
<link href="{{ asset('assets\libs\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/libs/datatables.net-autoFill-bs4/css/autoFill.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets\libs\datatables.net-keytable-bs4\css\keyTable.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

<!-- Responsive datatable examples -->
<link href="assets\libs\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">


@endpush
@section('title', __('User'))
@section('content')
<div class="container-fluid">
    <x-breadcrumbs name="{{ __('Post') }}" breadcrumb="admin.article"></x-breadcrumbs>
    {{-- <x-alert :errors="$errors"></x-alert> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @can('create post')
                    <div class="text-right pb-2">
                        <a href="{{ route('admin.createArticle') }}" class="btn btn-success"><i class="fas fa-plus"></i> {{ __('Add Post') }} </a>
                    </div>
                    @endcan
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-header thead-dark ">
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Created by') }}</th>
                            <th>{{ __('Avatar') }}</th>
                            @if(Auth::user()->can('edit post') || Auth::user()->can('delete post'))
                            <th>{{ __('Action') }}</th>
                            @endif

                        </thead>
                        <tbody>
                            @foreach ($articles as $key => $article)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $article->title }}</td>
                                    <td>
                                        {{ $article->user->username }}
                                    </td>
                                    <td>
                                        <img src="{{ $article->avatar }}" alt="" style="height: 100px" class="img-fluid">
                                    </td>
                                    @if(Auth::user()->can('edit post') || Auth::user()->can('view post') || Auth::user()->can('delete post'))
                                    <td>
                                        @can('edit post')
                                        <a href="{{ route('admin.editArticle' , $article->id) }}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                                        @endcan
                                        <a href="{{ route('article', $article->slug) }}" class="btn btn-primary"><i class="fas fa-eye"></i></a>
                                       
                                        @can('delete post')
                                        <a href="{{ route('admin.deleteArticle', $article->id)}}"class="btn btn-danger "><i class="fa fa-trash-alt"></i></a>
                                        @endcan
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets\libs\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets\libs\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets\libs\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets\libs\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->

    <script src="{{ asset('assets\js\pages\datatables.init.js') }}"></script> 
@endpush