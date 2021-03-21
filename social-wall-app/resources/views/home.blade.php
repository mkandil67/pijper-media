@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-3">
        <div class="row">

            <div class="col-md">

                <div id="accordion">
                    <div class="card mb-3">
                        <div class="card-header">
                            <a href="#collapseCard" data-toggle="collapse" class="collapsed">
                                Recent Activity
                                <span class="text-info readMore">(show more)</span>
                                <span class="text-danger readLess">(show less)</span>
                            </a></div>
                        <div id="collapseCard" class="collapse show" data-parent="#accordion">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                                @foreach(App\Models\Post::where('writer_id','>',0)->get() as $post)
                                    <div class="col m-2">
                                        <div class="card mb-4 shadow-sm h-100">
                                            <div class="card-body">
                                                <p class="text-justify ">Written by {{($post->writer_id == $user->id) ? 'you' : App\Models\User::find($post->writer_id)->name}}</p>
                                                <div class="card-body border">
                                                    <small class="card-text font-weight-bold">{{$post->caption}}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <a href="{{$post->post_url}}" type="button" class="btn btn-sm btn-outline-info font-weight-bold">Source</a>
                                                    <div class="d-flex flex-column">
                                                        <small class="text-danger font-weight-bold">Engagement: {{$post->engagement}}</small>
                                                        <small class="text-muted">{{$post->platform}}</small>
                                                        <small class="text-muted">{{$post->category}}</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-center pb-1">
                                                <small class="text-muted">Posted 3 mins ago</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card" id="postsCard">
                    <div class="card-header">{{ __('Posts') }}</div>
                        <div class="row p-3 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-5">
                            @foreach($posts as $post)
                                @if($categories[$post->category])
                                    <div class="col-md-4">
                                        <div class="card mb-4 shadow-sm h-100">
                                            <img src="{{$post->image_url}}" class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
                                            <div class="card-body">
                                                <div class="card-body border h-75">
                                                    <small class="card-text font-weight-bold">{{$post->caption}}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <div class="btn-group ">
                                                        <form action="{{route('posts', ['id' => $post->id, 'user' => $user->id])}}" method="POST" id="form">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$post->id}}">
                                                            @if(!empty($post->writer_id))
                                                                @if($post->writer_id == $user->id)
                                                                    <button type="submit" class="btn btn-sm btn-outline-danger font-weight-bold" id="removeActivity">Remove</button>
                                                                @else
                                                                    <span class="badge-danger">Unavailable</span>
                                                                @endif
                                                            @else
                                                              <button type="submit" class="btn btn-sm btn-outline-info font-weight-bold" id="addActivity">Add</button>
                                                            @endif
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
                                                <small class="text-muted">Posted 3 mins ago</small>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                </div>

            </div>
        </div>
    </div>
@endsection
