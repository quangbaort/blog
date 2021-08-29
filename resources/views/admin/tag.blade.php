@extends('admin.app')
@push('css')
<link href="{{ asset('assets\libs\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/libs/datatables.net-autoFill-bs4/css/autoFill.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets\libs\datatables.net-keytable-bs4\css\keyTable.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

<!-- Responsive datatable examples -->
<link href="assets\libs\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">

@endpush
@section('title', __('Tag'))
@section('content')
<div class="container-fluid">
    <x-breadcrumbs name="{{ __('Tag') }}" breadcrumb="admin.tag"></x-breadcrumbs>
    {{-- <x-alert :errors="$errors"></x-alert> --}}
     <!-- end page title -->

     <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @can('create tag')
                    <div class="text-right pb-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-add-tag"><i class="fas fa-plus"></i> {{ __('Add Tag') }} </button>
                    </div>
                    @endcan
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-header thead-dark ">
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('created_at') }}</th>
                            <th>{{ __('updated_at') }}</th>
                            @if(Auth::user()->can('update tag') || Auth::user()->can('view tag') || Auth::user()->can('delete tag'))
                            <th>{{ __('Action') }}</th>
                            @endif
                            
                        </thead>
                        <tbody>
                            @foreach ($tags as $key => $tag)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $tag->name }}</td>
                                    <td>{{ $tag->created_at }}</td>
                                    <td>{{ $tag->updated_at }}</td>
                                    <td>
                                        @can('update tag')
                                        <button class="btn btn-success" data-toggle="modal" data-target=".modal-update-{{ $tag->id }}"><i class="fas fa-edit"></i></button>
                                        @endcan
                                        @can('delete tag')
                                        <button class="btn btn-danger" data-toggle="modal" data-target=".modal-delete-{{ $tag->id }}"><i class="fas fa-trash-alt"></i></button>
                                        @endcan
                                    </td>
                                    
                                </tr>
                                @can('update tag')
                                <div class="modal fade modal-update-{{ $tag->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="">{{ __('Update tag') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.updateTag' , $tag->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name-{{ $tag->id }}">{{ __('name') }}:</label>
                                                        <input type="text" name="name"  class="form-control"value="{{ $tag->name }}"class="form-control" id="name-{{ $tag->id }}" placeholder="{{ __('Tag name')}}">
                                                        @error('name')
                                                            <span class="help-block text-danger"> {{ __($message) }}</span>                            
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button data-dismiss="modal" type="button" class="btn btn-secondary">{{ __('Close') }}</button>
                                                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                                                </div>
                                            </form>
                                            
                                        </div>
                                    </div>
                                </div>
                                @endcan
                                @can('delete tag')
                                <div class="modal fade modal-delete-{{ $tag->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="">{{ __('Warning') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <span>{{ __('Are you sure you want to delete this') }}</span>
                                                <span class="text-danger">{{ $tag->name }}</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-secondary">{{ __('Close') }}</button>
                                                <a href="{{ route('admin.deleteTag' , $tag->id) }}" class="btn btn-danger">{{ __('Delete') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endcan
                                
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
     </div>
</div>
@can('create tag')
<div class="modal fade" id="modal-add-tag" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">{{ __('Add tag') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.addTag') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('name') }}:</label>
                        <input type="text" name="name" value="{{ old('name')}}"class="form-control" id="name" placeholder="{{ __('tag name')}}">
                        @error('name')
                            <span class="help-block text-danger"> {{ __($message) }}</span>                            
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button data-dismiss="modal" type="button" class="btn btn-secondary">{{ __('Close') }}</button>
                    <button class="btn btn-primary" type="submit">{{ __('Save') }}</button>
                </div>
            </form>
            
        </div>
    </div>
</div>
@endcan
@endsection
@push('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets\libs\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets\libs\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets\libs\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets\libs\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="{{ asset('assets\js\pages\datatables.init.js') }}"></script> 
    @error('error_add_tag')
        <script>
            $('#modal-add-tag').modal('show');
        </script>
    @enderror
@endpush