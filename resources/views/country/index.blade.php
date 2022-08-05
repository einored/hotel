@extends('layouts.app')
@section('title', 'Countries')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col">
            <div class="card">
                <div class="card-header">Country list</div>

                <div class="card-body">
                    @include('msg.main')
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Country</th>
                                <th scope="col">Season</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        @forelse($countries as $country)
                        <tr>
                            <td>{{$country->id}}</td>
                            <td>{{$country->country_name}}</td>
                            <td>{{$country->season_time}}</td>
                            <td>
                                <a class="btn btn-success btn-sm" href="{{route('countries-edit', $country)}}">Edit</a>
                            </td>
                            <td>
                                <form class="delete" action="{{route('countries-delete', $country)}}" method="post">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-outline-warning btn-sm">Delete</button>
                            </form>
                            </td>
                        </tr>

                        @empty
                        <li>No Countries...</li>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
