@extends('admin.app')
@section('title', __('Profile'))
@section('content')
<div class="container-fluid">
    <x-breadcrumbs name="{{ __('Profile') }}" breadcrumb="admin.profile"></x-breadcrumbs>
    {{-- <x-alert :errors="$errors"></x-alert> --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('avatar') }}</h4>
                </div>
                <form action="{{ route('admin.updateAvatar') }}" enctype='multipart/form-data' method="post">
                    @csrf
                    <input accept="image/*" type="file" name="avatar" id="avatar" class="d-none">
                    <div class="card-body">
                        <div class="row">
                            <div class="col text-center" >
                                <img id="preview_avatar" 
                                src="{{ is_null(\Auth::user()->avatar) ? asset('image/user/user.png') : asset(\Auth::user()->avatar) }}" 
                                class="img-fluid img-thumbnail rounded-circle" style="width:200px;height:200px"  
                                alt="{{ __('avatar') . " " . Auth::user()->name }}"
                                title="{{ __('avatar') . " " . Auth::user()->name }}"
                                >
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-right">
                                <button class="btn btn-primary" id="btn-change__avatar" type="button">{{ __('Change avatar') }}</button>
                                
                                <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                                
                            </div>
                            
                        </div>
                    </div>
                </form>
                
            </div>
            
        </div>
        {{-- thay đổi avatar  --}}
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{ __('Information') }}</h4>
                </div>
                <form action="{{ route('admin.updateInfo') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col" style="padding-top : 20px; padding-bottom:20px">
                                <div class="form-group">
                                    <label for="username">{{ __('Username') }}:</label>
                                    <input id="username" autocomplete="off" type="text" value="{{ \Auth::user()->username }}" name="username" class="form-control">
                                    @error('username')
                                        <span class="help-block text-danger">{{ __($message) }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="name">{{ __('Name') }}:</label>
                                    <input id="name" type="text" autocomplete="off"  value="{{ \Auth::user()->name }}" name="name" class="form-control">
                                    @error('name')
                                        <span class="help-block text-danger">{{ __($message) }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col text-right">
                                <button type="button" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target=".bs-example-modal-center">{{ __('Reset password') }}</button>
                                <button class="btn btn-success" type="submit">{{ __('Save') }}</button>
                            </div>
                        </div>
                    </div>  
                </form>
                
            </div>
        </div>
        {{-- thay đổi thông tin cá nhân  --}}
    </div>
    <div class="modal fade bs-example-modal-center" tabindex="-1" id="resetPassword" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mt-0">{{ __('Reset password') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('admin.updatePassword') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="password_old">{{ __('Password old') }}:</label>
                            <input autocomplete="off" value="{{ old('password_old') }}" type="text" name="password_old" id="password_old" class="form-control">
                            @error('password_old')
                                <span class="help-block text-danger">{{ __($message) }}</span>
                            @enderror
                            @error('error_password')
                                <span class="help-block text-danger">{{ __($message) }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_new">{{ __('Password new') }}:</label>
                            <input autocomplete="off" value="{{ old('password_new') }}" type="text" name="password_new" id="password_new" class="form-control">
                            @error('password_new')
                                <span class="help-block text-danger">{{ __($message) }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_comfirm">{{ __('Password confirm') }}:</label>
                            <input autocomplete="off" type="text" value="{{ old('password_confirm') }}" name="password_comfirm" id="password_comfirm" class="form-control">
                            @error('password_comfirm')
                                <span class="help-block text-danger">{{ __($message) }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-right">
                            <button class="btn btn-secondary" type="button" class="close" data-dismiss="modal" aria-label="Close">{{ __('close') }}</button>
                            <button class="btn btn-success"  type="submit">{{ __('Save') }}</button>

                        </div>
                    </div>
                </form>
                
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    

</div>
@endsection
@push('script')
@error('error_password_reset')
<script>
    $('#resetPassword').modal('show')
</script>
    
@enderror
    <script>
        $('#btn-change__avatar').click(function() {
            $('#avatar').click();
        })
        document.getElementById('avatar').onchange = evt => {
        const [file] =  document.getElementById('avatar').files
            if (file) {
                document.getElementById('preview_avatar').src = URL.createObjectURL(file)
            }
        }
    </script>
@endpush