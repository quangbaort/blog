@extends('admin.app')
@push('css')
<link href="{{ asset('assets\libs\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/libs/datatables.net-autoFill-bs4/css/autoFill.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets\libs\datatables.net-keytable-bs4\css\keyTable.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

<!-- Responsive datatable examples -->
<link href="assets\libs\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2 {
        width: 100% !important;
    }
</style>

@endpush
@section('title', __('User'))
@section('content')
<div class="container-fluid">
    <x-breadcrumbs name="{{ __('Category') }}" breadcrumb="admin.category"></x-breadcrumbs>
    {{-- <x-alert :errors="$errors"></x-alert> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    @can('create category')
                    <div class="text-right pb-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-add-category"><i class="fas fa-plus"></i> {{ __('Add category') }} </button>
                    </div>    
                    @endcan
                    
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-header thead-dark ">
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('name') }}</th>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Updated at') }}</th>
                            @if(Auth::user()->can('update category') || Auth::user()->can('view category') || Auth::user()->can('delete category'))
                            <th>{{ __('Action') }}</th>
                            @endif

                        </thead>
                        <tbody>
                            @foreach ($categories as $key => $category)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->created_at }}</td>
                                    <td>{{ $category->updated_at }}</td>
                                    <td>
                                        @can('update category')
                                        <button class="btn btn-success" data-toggle="modal" data-target=".modal-update-{{ $category->id }}"><i class="fas fa-edit"></i></button>
                                        @endcan
                                        @can('delete category')
                                        <button class="btn btn-danger" data-toggle="modal" data-target=".modal-delete-{{ $category->id }}"><i class="fas fa-trash-alt"></i></button>
                                        @endcan
                                    </td>
                                </tr>
                                @can('update category')
                                <div class="modal fade modal-update-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="">{{ __('Update category') }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('admin.updateCategory' , $category->id) }}" method="POST">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="name">{{ __('name') }}:</label>
                                                        <input type="text" name="name" value="{{ old('name') ?? $category->name }}"class="form-control" id="name" placeholder="{{ __('category name')}}">
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
                                @can('delete category')
                                <div class="modal fade modal-delete-{{ $category->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
                                                <span class="text-danger">{{ $category->name }}</span>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-secondary">{{ __('Close') }}</button>
                                                <a href="{{ route('admin.deleteCategory' , $category->id) }}" class="btn btn-danger">{{ __('Delete') }}</a>
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
@can('create category')
<div class="modal fade" id="modal-add-category" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">{{ __('Add category') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.addCategory') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('name') }}:</label>
                        <input type="text" name="name" value="{{ old('name')}}"class="form-control" id="name" placeholder="{{ __('category name')}}">
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
    <script src="https://cdn.datatables.net/fixedheader/3.1.2/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>

    <script src="{{ asset('assets\js\pages\datatables.init.js') }}"></script> 
    @error('error_add_category')
        <script>
            $('#modal-add-category').modal('show');
        </script>
    @enderror
    @error('error_update_category')
        <script>
            $('.modal-update-{{ __($message) }}').modal('show');
        </script>
    @enderror
@endpush