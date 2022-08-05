@extends('layouts.app')
@section('title', 'Create')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Create order</div>

                <div class="card-body">
                    @include('msg.main')

                    <ul>
                        <form action="{{route('orders-store')}}" method="post">
                            <li>Hotel name</li>
                            <select class="form-control" name="create_order_hotel_id" required focus>
                                @foreach($hotels as $hotel)
                                <option value="{{$hotel->id}}">{{ $hotel->hotel_name }}</option>
                                @endforeach
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
