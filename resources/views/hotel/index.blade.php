@extends('layouts.app')
@section('title', 'Hotels')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            @include('parts.box')
            <div class="card">
                <div class="card-header">Hotel list</div>

                <div class="card-body">
                    @include('msg.main')
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Country</th>
                                <th scope="col">Hotel</th>
                                <th scope="col">Price</th>
                                <th scope="col">Image</th>
                                <th scope="col">Trip time</th>
                                @if(Auth::user()->role > 9)
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                                @endif
                            </tr>
                        </thead>
                        @forelse($hotels as $hotel)
                        <tr>
                            <td>{{$hotel->id}}</td>
                            {{-- <td>{{$hotel->country->country_name}}</td> --}}
                            <td>{{$hotel->country_name}}</td>
                            <td>{{$hotel->hotel_name}}</td>
                            <td>{{$hotel->price}}</td>
                            <td>{{$hotel->image}}</td>
                            <td>{{$hotel->trip_time}}</td>
                            @if(Auth::user()->role > 9)
                            <td>
                                <a class="btn btn-success btn-sm" href="{{route('hotels-edit', $hotel)}}">Edit</a>
                            </td>
                            <td>
                                <form class="delete" action="{{route('hotels-delete', $hotel)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-warning btn-sm">Delete</button>
                                </form>
                            </td>
                            @endif
                        </tr>

                        @empty
                        <li>No Hotels...</li>
                        @endforelse
                    </table>
                </div>
                @include('parts.pager')
            </div>
        </div>
    </div>
</div>
@endsection
