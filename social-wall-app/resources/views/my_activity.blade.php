@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-3">
        <div class="row">

            <div class="col-md">

                <div id="accordion">
                    <div class="card mb-3">
                        <div class="card-header">My Activity</div>
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                                @foreach($posts as $post)
                                    <div class="col m-2">
                                        <div class="card mb-4 shadow-sm h-100">
                                            <div class="card-body">
                                                <div class="card-body border">
                                                    <small class="card-text font-weight-bold">{{ Str::limit($post->caption, $limit = 280, $end = '...') }}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <div class="btn-group ">
                                                        <form action="{{route('posts', ['id' => $post->id, 'user' => $user->id])}}" method="POST" id="form">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$post->id}}">
                                                            <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold">Remove</button>
                                                            <a href="{{$post->post_url}}" type="button" class="btn btn-sm btn-outline-info font-weight-bold">Source</a>
                                                        </form>
                                                    </div>
                                                    <div class="d-flex flex-column">
                                                        <small class="text-danger font-weight-bold">Engagement: {{$post->engagement}}</small>
                                                        <small class="text-muted">{{$post->platform}}</small>
                                                        <small class="text-muted">{{$post->category}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center pb-1">
                                                <small class="text-muted">Posted {{$post->created_at->diffForHumans()}}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
