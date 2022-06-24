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
        <div class="row">
            <div class="col" id="category-index-left-col">
                <form action="{{ route('admin.categories.store') }}" method="post">
                    @csrf
                    <div class="mb-3 d-flex align-items-center add_category">
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="Type a category" aria-describedby="helperName">
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
