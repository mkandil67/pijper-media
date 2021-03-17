@extends('layouts.app')

@section('content')
    <div class="container-fluid pt-3">
        <div class="row">

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">{{ __('Selected Categories') }}</div>
                    <form action="/categories" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row"></div>

                            <input type="checkbox" name="categories[]" value="News" {{ ($categories['News']) ? 'checked' : '' }} > News<br/>
                            <input type="checkbox" name="categories[]" value="Showbizz/Entertainment" {{ ($categories['Showbizz/Entertainment']) ? 'checked' : '' }} > Showbizz/Entertainment<br/>
                            <input type="checkbox" name="categories[]"  value="Royals" {{ ($categories['Royals']) ? 'checked' : '' }} > Royals<br/>
                            <input type="checkbox" name="categories[]"  value="Food/Recipes" {{ ($categories['Food/Recipes']) ? 'checked' : '' }} > Food/Recipes<br/>
                            <input type="checkbox" name="categories[]"  value="Lifehacks" {{ ($categories['Lifehacks']) ? 'checked' : '' }} > Lifehacks<br/>
                            <input type="checkbox" name="categories[]"  value="Fashion" {{ ($categories['Fashion']) ? 'checked' : '' }} > Fashion<br/>
                            <input type="checkbox" name="categories[]"  value="Beauty" {{ ($categories['Beauty']) ? 'checked' : '' }} > Beauty<br/>
                            <input type="checkbox" name="categories[]"  value="Health" {{ ($categories['Health']) ? 'checked' : '' }} > Health<br/>
                            <input type="checkbox" name="categories[]"  value="Family" {{ ($categories['Family']) ? 'checked' : '' }} > Family<br/>
                            <input type="checkbox" name="categories[]"  value="House and garden" {{ ($categories['House and garden']) ? 'checked' : '' }} > House and Garden<br/>
                            <input type="checkbox" name="categories[]"  value="Cleaning" {{ ($categories['Cleaning']) ? 'checked' : '' }} > Cleaning<br/>
                            <input type="checkbox" name="categories[]"  value=" Lifestyle" {{ ($categories['Lifestyle']) ? 'checked' : '' }} > Lifestyle<br/>
                            <input type="checkbox" name="categories[]" value="Lifestyle" {{ ($categories['Lifestyle']) ? 'checked' : '' }} > Cars<br/>
                            <input type="checkbox" name="categories[]"  value="Crime" {{ ($categories['Crime']) ? 'checked' : '' }} > Crime<br/>


                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-5">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Submit') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="col-md">

                <div class="card mb-3">
                    <div class="card-header">{{ __('New articles') }}</div>

                    <div class="card-body">


                    </div>
                </div>

                <div class="card">
                    <div class="card-header">{{ __('Posts') }}</div>

                    <div class="card-body">



                    </div>
                </div>



            </div>

        </div>
    </div>
@endsection
