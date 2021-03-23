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
                                <span class="text-danger readLess">(show less)</span>
                                <span class="text-info readMore">(show more)</span>
                            </a></div>
                        <div id="collapseCard" class="collapse " data-parent="#accordion">
                            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-6">
                                @foreach(App\Models\Post::where('writer_id','>',0)->where('updated_at', '>=', \Carbon\Carbon::now()->subHour())->get() as $post)
                                    <div class="col m-2">
                                        <div class="card mb-4 shadow-sm h-100">
                                            <div class="card-body">
                                                <p class="text-justify ">Written by {{($post->writer_id == $user->id) ? 'you' : App\Models\User::find($post->writer_id)->name}}</p>
                                                <div class="card-body border">
                                                    <small class="card-text font-weight-bold">{{ Str::limit($post->caption, $limit = 280, $end = '...') }}</small>
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
                                                <small class="text-muted">Posted {{$post->created_at->diffForHumans()}}</small>
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
                            @foreach(App\Models\Post::where('writer_id','=',null)->get() as $post)
                                @if($categories[$post->category])
                                    <div class="col-md-4">
                                        <div class="card mb-4 shadow-sm h-100">
                                            <img src="{{$post->image_url}}" class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
                                            <div class="card-body">
                                                <div class="card-body border h-75">
                                                    <small class="card-text font-weight-bold">{{ Str::limit($post->caption, $limit = 280, $end = '...') }}</small>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center ">
                                                    <div class="btn-group ">
                                                        <form action="{{route('posts', ['id' => $post->id, 'user' => $user->id])}}" method="POST" id="form">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{$post->id}}">
                                                            <button href="{{route('home')}}" type="submit" class="btn btn-sm btn-outline-info font-weight-bold">Add</button>
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
                                @endif
                            @endforeach
                        </div>
                </div>

            </div>
        </div>
    </div>
@endsection
