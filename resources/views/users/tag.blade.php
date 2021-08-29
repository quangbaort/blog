@extends('users.layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            @foreach ($tag->article as $article)
           
            <div class="col-md-6">
                <a href="{{ route('article' , $article->slug) }}">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">{{ $article->title }}</h5>
                        </div>
                        <div class="card-body">
                            <p>Category : <a href="{{ route('category', $article->category->slug) }}">{{ $article->category->name }} </a></p>
                            <img class="img-thumbnail img-fluid" src="{{ $article->avatar }}" style="height:200px" alt="">
                        </div>
                        <div class="card-footer">
                            @if($article->tag->count() > 0)
                                <ul>
                                    @foreach ($article->tag as $tag)
                                        <li><a href="{{ route('tag' , $tag->slug) }}">{{ $tag->name }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                            <p>Created by : {{ $article->user->username }}</p>
                            <p>Created at : {{ $article->created_at }}</p>

                        </div>
                    </div>
                </a>
            </div>
            
                
            @endforeach
        </div>
       
    </div>
@endsection