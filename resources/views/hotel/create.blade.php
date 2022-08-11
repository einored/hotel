@extends('layouts.app')
@section('title', 'Create')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Create hotel</div>

                <div class="card-body">
                    @include('msg.main')

                    <ul>
                        <form action="{{route('hotels-store')}}" method="post" enctype="multipart/form-data">
                            <li>Country</li>
                            <select class="form-control" name="create_hotel_country_id" required focus>
                                <option value="" disabled selected>Please select country</option>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}">{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                            <li>Hotel name</li>
                            <input type="text" class="form-control" name="create_hotel_name" />
                            <li>Price</li>
                            <input type="text" class="form-control" name="create_hotel_price" />
                            <li>Image</li>
                            <input class="form-control" type="file" name="create_hotel_image" />
                            <li>Trip time</li>
                            <input type="number" class="form-control" name="create_hotel_trip_time" />
                            
                            @csrf
                            @method('post') 
                            <button type="submit" class="button-top-margin btn btn-success btn-sm">Create</button>
                        </form>
                    </ul>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
