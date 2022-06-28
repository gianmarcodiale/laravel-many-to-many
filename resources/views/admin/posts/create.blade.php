@extends('layouts.admin')

@section('content')
    <div class="container mb-5">
        <h2>Create New Post</h2>

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

        <form action="{{ route('admin.posts.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" name="title" id="title" class="form-control w-50 @error('title') is-invalid @enderror"
                    placeholder="" aria-describedby="titleHelp" value="{{ old('title') }}">
                <small id="titleHelp" class="text-muted">Insert title (max. 150 characters)</small>
            </div>

            {{-- Author --}}
            <div class="mb-3">
                <label for="author" class="form-label">Author</label>
                <input type="text" name="author" id="author"
                    class="form-control w-50 @error('author') is-invalid @enderror" placeholder="" aria-describedby="authorHelp"
                    value="{{ old('author') }}">
                <small id="authorHelp" class="text-muted">Insert author (max. 40 characters)</small>
            </div>

            {{-- Content --}}
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" name="content" id="content" rows="5">
                    {{ old('content') }}
                </textarea>
                <small id="contentHelp" class="text-muted">Insert content</small>
            </div>

            {{-- Cover image --}}
            <div class="mb-3">
                <label for="cover_image" class="form-label">Cover Image</label>
                {{-- Remember to insert the enctype inside the input tag in the form --}}
                <input type="file" name="cover_image" id="cover_image" class="form-control w-50" placeholder=""
                    aria-describedby="coverImageHelp" @error('cover_image') is-invalid @enderror>
                {{-- We can't use the old() value cause it may cause vulnerabilities --}}
                <small id="coverImageHelp" class="text-muted">Insert cover image</small>
            </div>

            {{-- Form select for categories --}}
            <div class="mb-3">
                <label for="category_id" class="form-label">Categories</label>
                <select class="form-control w-50 @error('category_id') is-invalid @enderror" name="category_id" id="category_id">
                    <option value="">Select Category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Form select for tags --}}
            <div class="mb-3">
                <label for="tags" class="form-label">Tags</label>
                {{-- Insert square brackets in name for select a list of tags --}}
                <select multiple class="form-select w-50" name="tags[]" id="tags" aria-label="tags">
                    <option value="" disabled>Select tags</option>
                    @forelse ($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @empty
                        <option value="">No tags</option>
                    @endforelse
                </select>
            </div>

            {{-- Submit button --}}
            <button type="submit" class="btn btn-primary text-white">Create Post</button>
        </form>
    </div>
@endsection
