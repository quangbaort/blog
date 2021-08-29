@extends('users.layouts.app')
@section('content')
    <div class="container">
        <h1>{{ $article->title }}</h1>
        <h2><a href="{{ route('category' , $article->category->slug) }}">{{ $article->category->name }}</a></h2>
        @if($article->tag->count() > 0)
        Tags:
        <ul>
            @foreach ($article->tag as $tag)
                <li class=""><a href="{{ route('tag' , $tag->slug) }}">{{ $tag->name }}</a></li>            
            @endforeach
        </ul>
        <div>
            <p>Created by: {{ $article->user->username }}</p>
            <p>Created at: {{ $article->created_at }}</p>
        </div>
        <div class="comtent">
            <img src="{{ $article->avatar }}" alt="" class="avatar img-fluid" style="height:200px">
            {!!  $article->article_text !!}
        </div>
        @endif
    </div>
    
@endsection