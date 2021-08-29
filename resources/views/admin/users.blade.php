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
    <x-breadcrumbs name="{{ __('Users') }}" breadcrumb="admin.users"></x-breadcrumbs>
    {{-- <x-alert :errors="$errors"></x-alert> --}}
     <!-- end page title -->

     <div class="row">
        <div class="col-12">
            <div class="card">
                
                <div class="card-body">
                    @can('create user')
                    <div class="text-right pb-2">
                        <button class="btn btn-success" data-toggle="modal" data-target="#modal-add-user"><i class="fas fa-plus"></i> {{ __('Add user') }} </button>
                    </div> 
                    @endcan
                    
                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                        <thead class="table-header thead-dark ">
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Username') }}</th>
                            <th>{{ __('name') }}</th>
                            <th>{{ __('Role') }}</th>
                            <th>{{ __('Created at') }}</th>
                            <th>{{ __('Updated at') }}</th>
                            @if(Auth::user()->can('edit user') || Auth::user()->can('view user') || Auth::user()->can('delete user'))
                            <th>{{ __('Action') }}</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        {{ $role->name . "," }}
                                    @endforeach
                                </td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                                <td>
                                    @can('edit user')
                                    <button class="btn btn-success" data-toggle="modal" data-target=".modal-update-{{ $user->id }}"><i class="fas fa-edit"></i>
                                    </button>
                                    @endcan
                                    @can('delete user')
                                    <button class="btn btn-danger" data-toggle="modal" data-target=".modal-delete-{{ $user->id }}"><i class="fas fa-trash-alt"></i></button>
                                    @endcan
                                </td>
                            </tr>
                            @can('edit user')
                            <div class="modal fade modal-update-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">{{ __('Update user') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.updateUser' , $user->id) }}" method="post" >
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="username-{{ $user->id }}">{{ __('Username') }}:</label>
                                                    <input type="text" value="{{  $user->username }}" id="username-{{ $user->id }}" name="username" class="form-control">
                                                    @error('username')
                                                        <span class="help-block text-danger">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="name-{{ $user->id }}">{{ __('Name') }}:</label>
                                                    <input type="text" value="{{ $user->name }}"  id="name-{{ $user->id }}" name="name" class="form-control">
                                                    @error('name')
                                                        <span class="help-block text-danger">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="role-{{ $user->id }}">{{ __('role') }}:</label>
                                                    <select name="role[]" multiple="multiple" id="role-{{ $user->id }}" class="form-control">
                                                        @foreach ($roles as $role)
                                                            
                                                            <option value="{{ $role->name }}" {{ in_array($role->name, \App\Helpers\Helper::getRoleOfUser($user->id)) ? 'selected' : '' }}>{{ $role->name }}</option>
                                                            
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modal-change-password-{{ $user->id }} " data-dismiss="modal">{{ __('Change password') }}</button>
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary" >{{ __('save') }}</button>
                                            </div>
                                        </form>
                                       
                                  </div>
                                </div>
                            </div>
                            
                            <div class="modal fade modal-change-password-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">{{ __('Change password user') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="{{ route('admin.changePasswordUser' , $user->id) }}" method="POST" class="form-horizontal">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label for="password-{{ $user->id }}">{{ __('Password') }}:</label>
                                                    <input type="password" id="password-{{ $user->id }}"name="password" value="{{ old('password') }}" class="form-control" placeholder=""/>
                                                    @error('password')
                                                        <span class="help-block text-danger">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                                <div class="form-group">
                                                    <label for="password_confirm-{{ $user->id }}">{{ __('Password confirm') }}:</label>
                                                    <input type="password" id="password_confirm-{{ $user->id }}" name="password_confirm" value="{{ old('password_confirm') }}" class="form-control" placeholder=""/>    
                                                    @error('password_confirm')
                                                        <span class="help-block text-danger">{{ __($message) }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                                                <button type="submit" class="btn btn-primary" >{{ __('save') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endcan
                            @can('delete user')
                            <div class="modal modal-delete-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="">{{ __('Warning') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                       
                                        <div class="modal-body">
                                            <span>
                                                {{ __('Are you sure you want to delete this') }} 
                                            </span>
                                            <span class="text-danger">{{ $user->name }}?</span>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-secondary" data-dismiss="modal"> {{ __('Close') }}
                                            </button>
                                            <a href="{{ route('admin.deleteUser' , $user->id) }}" class="btn btn-danger"  >{{ __('Delete') }}</a>
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
        </div> <!-- end col -->
    </div> <!-- end row -->
</div>
<!-- Modal -->
@can('create user')
<div class="modal fade" id="modal-add-user" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="">{{ __('Add user') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.addUser') }}" method="post" >
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="username">{{ __('Username') }}:</label>
                        <input type="text" id="username" value="{{ old('username')}}"name="username" class="form-control">
                        @error('username')
                            <span class="help-block text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="name">{{ __('Name') }}:</label>
                        <input type="text" id="name" value="{{ old('name')}}" name="name" class="form-control">
                        @error('name')
                            <span class="help-block text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="pasword">{{ __('Password') }}:</label>
                        <input type="text" value="{{old('password')}}" id="password" name="password" class="form-control">
                        @error('password')
                            <span class="help-block text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirm">{{ __('Password confirm') }}:</label>
                        <input type="text" id="password_confirm" value="{{ old('password_confirm')}}" name="password_password_confirm" class="form-control">
                        @error('password_confirm')
                            <span class="help-block text-danger">{{ __($message) }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">{{ __('Role') }}:</label>
                        <select name="role[]" id="role" multiple="multiple" class="form-control">
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
                    <button type="submit" class="btn btn-primary" >{{ __('add') }}</button>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $('select.form-control').select2({
            // placeholder: "{{ __('Role') }}"
        });
    </script>  
    @error('error_user')
        <script>
            $('.modal-update-{{ $message }}').modal('show');
        </script>
    @enderror
    @error('error_password')
        <script>
            $('.modal-change-password-{{ $message }}').modal('show');
        </script>
    @enderror

@endpush