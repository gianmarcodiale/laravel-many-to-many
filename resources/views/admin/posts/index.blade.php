@extends('layouts.admin')

@section('content')
    <div class="container">
        <h2>Posts</h2>
        <hr>
        {{-- Display redirection status --}}
        @if (session('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif

        <table class="table table-striped table-inverse table-responsive">
            <thead class="thead-inverse">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Cover Image</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                    <tr>
                        <td scope="row">{{ $post->id }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->author }}</td>
                        <td><img width="120" src="{{ $post->cover_image }}" alt="cover image"></td>
                        <td>{{ $post->slug }}</td>
                        <td>
                            <div class="actions d-flex">
                                <a class="btn btn-primary btn-sm text-white me-1"
                                    href="{{ route('admin.posts.show', $post->slug) }}">View</a>
                                <a class="btn btn-secondary btn-sm text-white me-1"
                                    href="{{ route('admin.posts.edit', $post->slug) }}">Edit</a>

                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-danger btn-sm text-white" data-bs-toggle="modal"
                                    data-bs-target="#delete-post-{{ $post->id }}">
                                    Delete
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="delete-post-{{ $post->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="modelTitle-{{ $post->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Delete {{ $post->title }}?</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this post? This action is irreversible.
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <form action="{{ route('admin.posts.destroy', $post->slug) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger text-white" type="submit">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td scope="row">Nothing to show yet!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
