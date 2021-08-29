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
@section('title', __('Role'))
@section('content')
<div class="container-fluid">
    <x-breadcrumbs name="{{ __('Role') }}" breadcrumb="admin.role"></x-breadcrumbs>
    {{-- <x-alert :errors="$errors"></x-alert> --}}
     <!-- end page title -->

     <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="text-right pb-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-add-role"><i class="fas fa-plus"></i> {{ __('Add role') }} </button>
                    </div>
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-header thead-dark ">
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('name') }}</th>
                            @if(Auth::user()->can('user grant'))
                            <th>{{ __('Action') }}</th>
                            @endif
                        </thead>
                        <tbody>
                            @foreach ($roles as $key => $role)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @can('user grant')
                                    <button class="btn btn-success" data-toggle="modal" data-target=".modal-update-{{ $role->id }}"><i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-danger" data-toggle="modal" data-target=".modal-delete-{{ $role->id }}"><i class="fas fa-trash-alt"></i></button>
                                    @endcan
                                </td>
                            </tr>
                            @can('user grant')
                            <div class="modal fade modal-update-{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">{{ __('Update role') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.updateRole' , $role->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="name-{{ $role->id }}">{{ __('name') }}:</label>
                                                    <input type="text" name="name" disabled="true" readonly="true" class="form-control"value="{{ $role->name }}"class="form-control" id="name-{{ $role->id }}" placeholder="{{ __('role name')}}">
                                                    @error('name')
                                                        <span class="help-block text-danger"> {{ __($message) }}</span>                            
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="permission-{{ $role->id }}">{{ __('Permission') }}:</label>
                                                    <select name="permissions[]" multiple="multiple" id="permission-{{ $role->id }}" class="form-control">
                                                        @foreach ($permissions as $permission)
                                                            <option value="{{ $permission->name }} "{{ in_array($permission->name , \App\Helpers\Helper::getPermissionsOfRole($role->name)) ? 'selected' : '' }} >{{ $permission->name }}</option>
                                                        @endforeach
                                                    </select>
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
                            <div class="modal fade modal-delete-{{ $role->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
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
                                            <span class="text-danger">{{ $role->name }}</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-dismiss="modal" class="btn btn-secondary">{{ __('Close') }}</button>
                                            <a href="{{ route('admin.deleteRole' , $role->id) }}" class="btn btn-danger">{{ __('Delete') }}</a>
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
@can('user grant')
<div class="modal fade" id="modal-add-role" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">{{ __('Add role') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.addRole') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">{{ __('name') }}:</label>
                        <input type="text" name="name" value="{{ old('name')}}"class="form-control" id="name" placeholder="{{ __('role name')}}">
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="{{ asset('assets\js\pages\datatables.init.js') }}"></script> 
    <script>
        $('select.form-control').select2({
            // placeholder: "{{ __('Role') }}"
            matcher: function(params, data) {
                // If there are no search terms, return all of the data
                if ($.trim(params.term) === '') { return data; }

                // Do not display the item if there is no 'text' property
                if (typeof data.text === 'undefined') { return null; }

                // `params.term` is the user's search term
                // `data.id` should be checked against
                // `data.text` should be checked against
                var q = params.term.toLowerCase();
                if (data.text.toLowerCase().indexOf(q) > -1 || data.id.toLowerCase().indexOf(q) > -1) {
                    return $.extend({}, data, true);
                }

                // Return `null` if the term should not be displayed
                return null;
            }
        });
    </script>  
    @error('error_add_role')
        <script>
            $('#modal-add-role').modal('show')
        </script>
    @enderror
@endpush