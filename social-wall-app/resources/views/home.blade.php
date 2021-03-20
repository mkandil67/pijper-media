@extends('layouts.app')


@section('content')
    <div class="container-fluid pt-3">
        <div class="row">

            <div class="col-md">
                <div class="card mb-3">
                    <div class="card-header">{{ __('Recent Activity') }}</div>
                </div>

                <div class="card mb-3">
                    <div class="card-header">{{ __('Posts') }}</div>
                        <div class="row p-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5 ">
                            @foreach($posts as $post)

                                <div class="col pb-3">
                                    <div class="card shadow-sm">

                                        <img class="card-img-top" src="{{$post->image_url}}" width="100%" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                                        <div class="card-body">
                                            <p class="card-text font-weight-bold">{{$post->caption}}.</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div class="btn-group-vertical">
                                                    <form action="{{route('posts', ['id' => $post->id, 'user' => $user->id])}}" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="{{$post->id}}">
                                                        <button type="submit" class="btn btn-md btn-outline-info font-weight-bold">Add</button>
                                                    </form>
                                                    <a href="{{$post->post_url}}" type="button" class="btn btn-md btn-outline-info font-weight-bold">Source</a>
                                                </div>
                                                <div class="card border-0">
                                                    <span class="text-muted">{{$post->platform}}</span>
                                                    <span class="text-muted">{{$post->category}}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <small class="text-muted">Posted 3 mins ago</small>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                        </div>
                </div>

            </div>
        </div>
    </div>
@endsection
