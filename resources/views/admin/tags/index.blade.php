@extends('layouts.admin')

@section('content')
    <h1>Tags</h1>

    {{-- Display redirection status --}}
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    {{-- Create grid for data --}}
    <div class="container">
        <div class="row">
            <div class="col" id="tag-index-left-col">
                <form action="{{ route('admin.tags.store') }}" method="post">
                    @csrf
                    <div class="mb-3 d-flex align-items-center add_tag">
                        <input type="text" name="name" id="name" class="form-control" placeholder="Add tag"
                            aria-describedby="helperName">
                        <div class="ms-1">
                            <button type="submit" class="btn btn-primary text-white">Add</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col">
                <table class="table table-striped table-inverse table-responsive">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Post Count</th>
                            <th>Slug</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tags as $tag)
                            <tr>
                                <td scope="row">{{ $tag->id }}</td>
                                <td>
                                    <form id="tag-{{ $tag->id }}"
                                        action="{{ route('admin.tags.update', $tag->slug) }}" method="post">
                                        @csrf
                                        {{-- PATCH because we edit only one value --}}
                                        @method('PATCH')
                                        <input class="border-0 bg-transparent" type="text" name="name"
                                            value="{{ $tag->name }}">
                                    </form>
                                </td>
                                <td><span class="badge badge-info bg-primary">{{ count($tag->posts) }}</span></td>
                                <td>{{ $tag->slug }}</td>
                                <td>
                                    {{-- Implement button with form attribute with ID for form sumbit --}}
                                    <div class="actions d-flex">
                                        <button form="tag-{{ $tag->id }}" type="submit"
                                            class="btn btn-primary btn-sm text-white me-1">Update</button>
                                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm text-white">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>Nothing to show!</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
