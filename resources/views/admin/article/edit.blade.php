@extends('admin.app')
@push('css')
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
    <x-breadcrumbs name="{{ __('Create') }}" breadcrumb="admin.createArticle"></x-breadcrumbs>
    {{-- <x-alert :errors="$errors"></x-alert> --}}
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.updateArticle' , $article->id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">{{ __('Title') }}:</label>
                            <input type="text" value="{{ old('title') ?? $article->title }}" name="title" class="form-control">
                            @error('title')
                                <span class="help-block text-danger">{{ __($message) }}</span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                              <button class="input-group-text" id="btn-upload-avatar" type="button" id="basic-addon1">{{ __('Upload avatar') }}</button>
                            </div>
                            <input type="text" value="{{ old('avatar') ?? $article->avatar }}"readonly class="form-control" id="avatar" name="avatar" placeholder="file" aria-label="file" aria-describedby="basic-addon1">
                            
                        </div>
                        @error('avatar')
                            <span class="help-block text-danger">{{ __($message) }}</span>
                        @enderror

                        <textarea name="article_text"  id="article_text" cols="30" rows="10">{{ old('article_text') ?? $article->article_text }}</textarea>
                        @error('article_text')
                            <span class="help-block text-danger">{{ __($message) }}</span>
                        @enderror
                        <div class="form-group">
                            <label for="category">{{ __('Category') }}:</label>
                            <select name="category_id" multy class="form-control" id="category">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="help-block text-danger">{{ __($message) }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tag">{{ __('Tags') }}:</label>
                            <select name="tag_id[]" multiple="multiple" class="form-control" id="tag">
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}" {{ in_array($tag->id , \App\Helpers\Helper::getTagOfArticle($article->id)) ? 'selected' : '' }}>{{ $tag->name }}</option>
                                @endforeach
                            </select>
                            @error('tag_id')
                                <span class="help-block text-danger">{{ __($message) }}</span>
                            @enderror
                        </div>
                        <button class="w-100 btn btn-primary" type="submit">{{ __('Add post') }}</button>
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src={{ url('ckeditor/ckeditor.js') }}></script>
    <script>
    CKEDITOR.replace( 'article_text', {
        filebrowserBrowseUrl: '{{ route('ckfinder_browser') }}',

    } );
    </script>
    @include('ckfinder::setup')
    <script src="{{ asset('assets\js\pages\datatables.init.js') }}"></script> 
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $('select#tag').select2({
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
        var btnUploadAvatar = document.getElementById( 'btn-upload-avatar' );
        btnUploadAvatar.onclick = function() {
            selectFileWithCKFinder( 'avatar' );
        };
        function selectFileWithCKFinder( elementId ) {
            CKFinder.modal( {
                chooseFiles: true,
                width: 800,
                height: 600,
                onInit: function( finder ) {
                    finder.on( 'files:choose', function( evt ) {
                        var file = evt.data.files.first();
                        var output = document.getElementById( elementId );
                        output.value = file.getUrl();
                    } );
                    finder.on( 'file:choose:resizedImage', function( evt ) {
                        var output = document.getElementById( elementId );
                        output.value = evt.data.resizedUrl;
                    } );
                }
            } );
        }
    </script>
@endpush