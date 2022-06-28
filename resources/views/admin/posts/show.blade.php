@extends('layouts.admin')

@section('content')
    <div class="container" id="postShow">
        <div class="row justify-content-center p-4">
            <div class="postCard border border-secondary rounded p-4">
                <div class="postImage">
                    <img class="img-fluid" src="{{ $post->cover_image }}" alt="">
                </div>
                <div class="metadata mt-4">
                    <figure>
                        <blockquote class="blockquote">
                            <h4>{{ $post->title }}</h4>
                            <figcaption class="blockquote-footer mt-3">
                                Author: <cite title="author">{{ $post->author }}</cite>
                            </figcaption>
                        </blockquote>
                    </figure>
                    <div class="metadata mb-2 text-underline">
                        <div class="category">
                            <strong>Category: </strong> <em>{{ $post->category ? $post->category->name : 'N/A' }}</em>
                        </div>
                        {{-- tags div with if cycle for iterate checking if tags exists --}}
                        <div class="tags">
                            <strong>Tags: </strong>
                            @if (count($post->tags) > 0)
                                {{-- foreach for displaying tags --}}
                                @foreach ($post->tags as $tag)
                                    <span>#{{ $tag->name }} </span>
                                @endforeach
                            @else
                                <span>N/A</span>
                            @endif
                        </div>
                    </div>
                    <p>{{ $post->content }}</p>
                    <small class="text-primary">{{ $post->slug }}</small>
                </div>
            </div>
        </div>
    </div>
@endsection
