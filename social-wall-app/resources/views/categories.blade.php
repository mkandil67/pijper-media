@extends('layouts.app')

{{-- CATEGORIES PAGE --}}

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Choose the categories you would like to follow') }}</div>
                    <form action="/categories" method="POST">
                        @csrf
                        <div class="card-body">
                                <div class="form-group row"></div>
                                        <label>Which Categories would you like to add?</label><br/>

                                        <input type="checkbox" name="categories[]" value="News"> News<br/>
                                        <input type="checkbox" name="categories[]" value="Showbizz/Entertainment"> Showbizz/Entertainment<br/>
                                        <input type="checkbox" name="categories[]"  value="Royals"> Royals<br/>
                                        <input type="checkbox" name="categories[]"  value="Food/Recipes"> Food/Recipes<br/>
                                        <input type="checkbox" name="categories[]"  value="Lifehacks"> Lifehacks<br/>
                                        <input type="checkbox" name="categories[]"  value="Fashion"> Fashion<br/>
                                        <input type="checkbox" name="categories[]"  value="Beauty"> Beauty<br/>
                                        <input type="checkbox" name="categories[]"  value="Health"> Health<br/>
                                        <input type="checkbox" name="categories[]"  value="Family"> Family<br/>
                                        <input type="checkbox" name="categories[]"  value="Fashion"> Fashion<br/>
                                        <input type="checkbox" name="categories[]"  value="House and garden"> House and Garden<br/>
                                        <input type="checkbox" name="categories[]"  value="Cleaning"> Cleaning<br/>
                                        <input type="checkbox" name="categories[]"  value=" Lifestyle"> Lifestyle<br/>
                                        <input type="checkbox" name="categories[]" value="Cars"> Cars<br/>
                                        <input type="checkbox" name="categories[]"  value="Crime"> Crime<br/>


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
        </div>
    </div>
@endsection
