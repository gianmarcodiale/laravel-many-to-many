@extends('layouts.admin')

@section('content')
    <div class="container mb-5">
        <h2>Edit {{ $post->title }}</h2>

        {{-- Display error message in case of invalid data --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.posts.update', $post->slug) }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control w-50 @error('title') is-invalid @enderror"
                    placeholder="" aria-describedby="titleHelp" value="{{ old('title', $post->title) }}">
                <small id="titleHelp" class="text-muted">Edit title (max. 150 characters)</small>
            </div>

            {{-- Author --}}
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" id="author"
                    class="form-control w-50 @error('author') is-invalid @enderror" placeholder="" aria-describedby="authorHelp"
                    value="{{ old('author', $post->author) }}">
                <small id="authorHelp" class="text-muted">Edit author (max. 40 characters)</small>
            </div>

            {{-- Content --}}
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="content" rows="5">
                    {{ old('content', $post->content) }}
                </textarea>
                <small id="contentHelp" class="text-muted">Edit content</small>
            </div>

            {{-- Cover image --}}
            <div class="d-flex">
                <div class="media me-3">
                    <img class="shadow" width="150" src="{{ asset('storage/' . $post->cover_image) }}" alt="">
                </div>
                <div class="mb-3">
                    <label for="cover_image" class="form-label">Cover Image</label>
                    <input type="file" name="cover_image" id="cover_image" class="form-control @error('cover_image') is-invalid @enderror" placeholder=""
                        aria-describedby="coverImageHelp">
                    <small id="coverImageHelp" class="text-muted">Edit cover image</small>
                </div>
            </div>

            {{-- Form select for categories --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Categories</label>
                <select class="form-control w-50 @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ $category->id == old('category_id', $post->category ? $post->category_id : '') ? 'selected' : '' }}>
                            {{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- form select for tags --}}
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                {{-- Insert square brackets in name for select a list of tags --}}
                <select multiple class="form-select w-50" name="tags[]" id="tags" aria-label="tags">
                    <option value="" disabled>Select tags</option>
                    @forelse ($tags as $tag)
                        {{-- Create an if statement for checking validation errors. If there is some validation error means that old exist. So if exist means that there are some errors in the validation and return the previously selected tags --}}
                        @if ($errors->any())
                            <option value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', [])) ? 'selected' : '' }}>
                                {{ $tag->name }}</option>
                            {{-- If old doesn't exist we render the post tags list --}}
                        @else
                            <option value="{{ $tag->id }}" {{ $post->tags->contains($tag->id) ? 'selected' : '' }}>
                                {{ $tag->name }}</option>
                        @endif
                    @empty
                        <option value="">No tags</option>
                    @endforelse
                </select>
            </div>

            {{-- Submit button --}}
            <button type="submit" class="btn btn-primary text-white">Edit Post</button>
        </form>
    </div>
@endsection
