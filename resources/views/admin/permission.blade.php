@extends('admin.app')
@push('css')
<link href="{{ asset('assets\libs\datatables.net-bs4\css\dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets/libs/datatables.net-autoFill-bs4/css/autoFill.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">
<link href="{{ asset('assets\libs\datatables.net-keytable-bs4\css\keyTable.bootstrap4.min.css') }}" rel="stylesheet" type="text/css">

<!-- Responsive datatable examples -->
<link href="assets\libs\datatables.net-responsive-bs4\css\responsive.bootstrap4.min.css" rel="stylesheet" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('title', __('Permisions'))
@section('content')
<div class="container-fluid">
    <x-breadcrumbs name="{{ __('Permissions') }}" breadcrumb="admin.permissions"></x-breadcrumbs>
    {{-- <x-alert :errors="$errors"></x-alert> --}}
     <!-- end page title -->

    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="text-right pb-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-add-permission"><i class="fas fa-plus"></i> {{ __('Add permission') }} </button>
                    </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-header thead-dark ">
                            <th>{{ __('ID') }}</th>
                            
                            <th>{{ __('Permissions') }}</th>
                            {{-- <th>{{ __('Action') }}</th> --}}
                        </thead>
                        <tbody>
                            @foreach ($permissions as $key => $permission)
                            <tr>
                                <td>{{ $key+1  }}</td>
                                <td>{{ $permission->name }}</td>
                                {{-- <td>
                                    <button class="btn btn-danger" data-toggle="modal" data-target=".modal-delete-{{ $permission->id }}"><i class="fas fa-trash-alt"></i></button>
                                </td> --}}
                            </tr>
                            {{-- <div class="modal fade modal-delete-{{ $permission->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
                                            <span class="text-danger">{{ $permission->name }}</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-secondary">{{ __('Close') }}</button>
                                            <a href="{{ route('admin.deletePermission' , $permission->id) }}" class="btn btn-danger">{{ __('Delete') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-add-permission" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">{{ __('Add permission') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.addPermission') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('name') }}:</label>
                        <input type="text" name="name" value="{{ old('name')}}"class="form-control" id="name" placeholder="{{ __('Permission name')}}">
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
@endsection
@push('script')
    <!-- Required datatable js -->
    <script src="{{ asset('assets\libs\datatables.net\js\jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets\libs\datatables.net-bs4\js\dataTables.bootstrap4.min.js') }}"></script>

    <script src="{{ asset('assets\libs\datatables.net-responsive\js\dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets\libs\datatables.net-responsive-bs4\js\responsive.bootstrap4.min.js') }}"></script>

    <!-- Datatable init js -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets\js\pages\datatables.init.js') }}"></script> 
    @error('error_add_permission')
    <script>
        $('#modal-add-permission').modal('show')
    </script>
@enderror
@endpush