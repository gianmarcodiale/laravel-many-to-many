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
        <div class="row d-block">
            <div class="col" id="tag-index-left-col">
                <form action="{{ route('admin.tags.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3 d-flex align-items-center add_tag mt-3 w-50">
                        <span class="input-group-text" id="basic-addon1" style="height:37px"><svg
                                xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-tag" viewBox="0 0 16 16">
                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                                <path
                                    d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                            </svg>
                        </span>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Add tag"
                            aria-describedby="basic-addon1" aria-label="Add tag">
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
