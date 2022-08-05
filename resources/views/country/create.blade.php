@extends('layouts.app')
@section('title', 'Create')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Create country</div>

                <div class="card-body">
                    @include('msg.main')

                    <ul>
                        <form action="{{route('countries-store')}}" method="post">
                            <li>Country name</li>
                            <input type="text" class="form-control" name="create_country_name" />
                            <li>Season</li>
                            <select class="form-control" name="create_country_season_time" required focus>
                                <option value="Winter">Winter</option>
                                <option value="Spring">Spring</option>
                                <option value="Summer">Summer</option>
                                <option value="Autumn">Autumn</option>
                            </select>
                            @csrf
                            <button type="submit" class="button-top-margin btn btn-success btn-sm">Create</button>
                        </form>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
