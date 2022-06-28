@extends('layouts.admin')

@section('content')
    <h1>Categories</h1>

    {{-- Display redirection status --}}
    @if (session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    {{-- Create grid for data --}}
    <div class="container">
        <div class="row d-block">
            <div class="col" id="category-index-left-col">
                <form action="{{ route('admin.categories.store') }}" method="post">
                    @csrf
                    <div class="input-group mb-3 d-flex align-items-center add_category mt-3 w-50">
                        <span class="input-group-text" id="basic-addon1" style="height:37px">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-bookmark-plus" viewBox="0 0 16 16">
                                <path
                                    d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z" />
                                <path
                                    d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z" />
                            </svg>
                        </span>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Add category" aria-describedby="basic-addon1">
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
                        @forelse ($categories as $category)
                            <tr>
                                <td scope="row">{{ $category->id }}</td>
                                <td>
                                    <form id="category-{{ $category->id }}"
                                        action="{{ route('admin.categories.update', $category->slug) }}" method="post">
                                        @csrf
                                        {{-- PATCH because we edit only one value --}}
                                        @method('PATCH')
                                        <input class="border-0 bg-transparent" type="text" name="name"
                                            value="{{ $category->name }}">
                                    </form>
                                </td>
                                <td><span class="badge badge-info bg-primary">{{ count($category->posts) }}</span></td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    {{-- Implement button with form attribute with ID for form sumbit --}}
                                    <div class="actions d-flex">
                                        <button form="category-{{ $category->id }}" type="submit"
                                            class="btn btn-primary btn-sm text-white me-1">Update</button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="post">
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
