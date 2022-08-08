@extends('layouts.app')
@section('title', 'Edit')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Edit hotel</div>

                <div class="card-body">
                    @include('msg.main')
                    <ul>
                        <form action="{{route('hotels-edit', $hotel)}}" method="post" enctype="multipart/form-data">
                            <li>Country</li>
                            <select class="form-control" name="hotel_country_id" required focus>
                                @foreach($countries as $country)
                                <option value="{{$country->id}}" {{old('hotel_country_id', $hotel->country_id)==$country->id?'selected':''}}>{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                            <li>Hotel name</li>
                            <input type="text" class="form-control" name="hotel_name" value="{{old('hotel_name', $hotel->hotel_name)}}" />
                            <li>Price</li>
                            <input type="text" class="form-control" name="hotel_price" value="{{old('hotel_price', $hotel->price)}}" />
                            <li>Image</li>
                            @if($hotel->image)
                            <div class="image-box">
                                <img src="{{$hotel->image}}">
                            </div>
                            @endif
                            <input class="form-control" type="file" name="hotel_image" />
                            {{-- <input type="text" class="form-control" name="hotel_image" value="{{old('hotel_image', $hotel->image)}}" /> --}}
                            <li>Trip time</li>
                            <input type="number" class="form-control" name="hotel_trip_time" value="{{old('hotel_trip_time', $hotel->trip_time)}}" />
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
