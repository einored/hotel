@extends('layouts.app')
@section('title', 'Orders')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Order list</div>
                @if(Auth::user()->role > 9)
                <div class="card-body">
                    @include('msg.main')
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Hotel</th>
                                <th scope="col">User name</th>
                                <th scope="col">Status</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        @forelse($orders as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->hotel->hotel_name}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>{{$order->status}}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{route('orders-edit', $order)}}">Edit</a>
                            </td>
                            <td>
                                <form class="delete" action="{{route('orders-delete', $order)}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-outline-warning btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>

                        @empty
                        <li>No Orders...</li>
                        @endforelse
                    </table>
                </div>
                @endif
                @if(Auth::user()->role < 9) <div class="card-body">
                    @include('msg.main')
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Hotel</th>
                                <th scope="col">Status</th>
                            </tr>
                        </thead>
                        @forelse($orders as $order)
                        @if(Auth::user()->id == $order->user_id)
                        <tr>
                            <td>{{$order->hotel->hotel_name}}</td>
                            <td>{{$order->status}}</td>
                        </tr>


                        @endif
                        @empty
                        <li>No Orders...</li>
                        @endforelse
                    </table>
            </div>
            @endif
        </div>
    </div>
</div>
</div>
@endsection
