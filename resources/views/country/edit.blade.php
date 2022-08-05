@extends('layouts.app')
@section('title', 'Edit')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Edit country</div>

                <div class="card-body">
                    @include('msg.main')
                    <ul>
                        <form action="{{route('countries-edit', $country)}}" method="post">
                            <li>Country name</li>
                            <input type="text" class="form-control" name="country_name" value="{{old('country_name', $country->country_name)}}" />
                            <li>Season</li>
                            <select class="form-control" name="country_season_time" required focus>
                                <option value="Winter" {{old('country_season_time', $country->season_time)=='Winter'?'selected':''}}>Winter</option>
                                <option value="Spring" {{old('country_season_time', $country->season_time)=='Spring'?'selected':''}}>Spring</option>
                                <option value="Summer" {{old('country_season_time', $country->season_time)=='Summer'?'selected':''}}>Summer</option>
                                <option value="Autumn" {{old('country_season_time', $country->season_time)=='Autumn'?'selected':''}}>Autumn</option>
                            </select>
                            @csrf
                            @method('put')
                            <button type="submit" class="button-top-margin btn btn-success btn-sm">Edit</button>
                        </form>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
