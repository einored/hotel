<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Country;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use Illuminate\Http\Request;
use DB;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->s) {
            list($w1, $w2) = explode(' ', $request->s . ' ');

            $hotelsDir = [DB::table('hotels')
                ->join('countries', 'countries.id', '=', 'hotels.country_id')
                ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                ->where('countries.country_name', 'like', '%'.$w1.'%')
                ->where('hotels.hotel_name', 'like', '%'.$w2.'%')
                ->orWhere(fn($query) => $query
                ->where('countries.country_name', 'like', '%'.$w2.'%')
                ->where('hotels.hotel_name', 'like', '%'.$w1.'%'))
                ->orWhere(fn($query) => $query
                ->where('hotels.hotel_name', 'like', '%'.$w2.'%')
                ->where('hotels.hotel_name', 'like', '%'.$w1.'%'))
                ->orderBy('hotels.hotel_name', 'asc')
                ->get(), 'default'];
            $filter = 0;
        }
        else {
            if (!$request->country_id) {

                $hotelsDir = match($request->sort) {
                    'price-asc' => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->orderBy('hotels.price', 'asc')
                                    ->get(), 'price-asc'],
                    'price-desc' => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->orderBy('hotels.price', 'desc')
                                    ->get(), 'price-desc'],            
                    default => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->orderBy('hotels.id', 'desc')
                                    ->get(), 'default']
                };
                $filter = 0;
            }
            else {
                $hotelsDir = match($request->sort) {
                    'price-asc' => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->where('countries.id', $request->country_id)
                                    ->orderBy('hotels.price', 'asc')
                                    ->get(), 'price-asc'],
                    'price-desc' => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->where('countries.id', $request->country_id)
                                    ->orderBy('hotels.price', 'desc')
                                    ->get(), 'price-desc'],            
                    default => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->orderBy('hotels.id', 'desc')
                                    ->get(), 'default']
                };
                $filter = (int) $request->country_id;
            }
        }
        

        return view('hotel.index', [
            'hotels' => $hotelsDir[0],
            'sort' => $hotelsDir[1],
            'countries' => Country::all(),
            'filter' => $filter,
            's' => $request->s ?? ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::all();

        return view('hotel.create', ['countries' => $countries]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreHotelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hotel = new Hotel;

        $hotel->country_id = $request->create_hotel_country_id;
        $hotel->hotel_name = $request->create_hotel_name;
        $hotel->price = $request->create_hotel_price;
        $hotel->image = $request->create_hotel_image;
        $hotel->trip_time = $request->create_hotel_trip_time;

        $hotel->save();

        return redirect()->route('hotels-index')->with('success', 'Created new hotel!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {
        $countries = Country::all();

        return view('hotel.edit', ['hotel' => $hotel, 'countries' => $countries]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateHotelRequest  $request
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {        
        $hotel->country_id = $request->hotel_country_id;
        $hotel->hotel_name = $request->hotel_name;
        $hotel->price = $request->hotel_price;
        $hotel->image = $request->hotel_image;
        $hotel->trip_time = $request->hotel_trip_time;

        $hotel->save();

        return redirect()->route('hotels-index')->with('success', 'Hotel updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hotel  $hotel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hotel $hotel)
    {
        $hotel->delete();

        return redirect()->route('hotels-index')->with('delete', 'Hotel deleted!');
    }
}
