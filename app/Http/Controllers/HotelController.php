<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Country;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreHotelRequest;
use App\Http\Requests\UpdateHotelRequest;
use Illuminate\Http\Request;
use DB;

class HotelController extends Controller
{
    private $perPage = 10;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->s) {
            list($w1, $w2) = explode(' ', $request->s . ' ');

            $allCount = DB::table('hotels')
            ->join('countries', 'countries.id', '=', 'hotels.country_id')
            ->select(DB::raw('count(hotels.id) AS allHotels'))
            ->where('countries.country_name', 'like', '%'.$w1.'%')
            ->where('hotels.hotel_name', 'like', '%'.$w2.'%')
            ->orWhere(fn($query) => $query
            ->where('countries.country_name', 'like', '%'.$w2.'%')
            ->where('hotels.hotel_name', 'like', '%'.$w1.'%'))
            ->orWhere(fn($query) => $query
            ->where('hotels.hotel_name', 'like', '%'.$w2.'%')
            ->where('hotels.hotel_name', 'like', '%'.$w1.'%'))
            ->first()->allHotels;
                  
            $page = $request->page ?? 1;
 
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
                ->offset(($page - 1) * $this->perPage)
                ->limit($this->perPage)
                ->get(), 'default'];
            $filter = 0;
        }
        else {
            if (!$request->country_id) {

                $allCount = DB::table('hotels')
                ->select(DB::raw('count(hotels.id) AS allHotels, count(DISTINCT(hotels.hotel_name)) AS allNames'))
                ->first()->allHotels;
                $page = $request->page ?? 1;

                $hotelsDir = match($request->sort) {
                    'price-asc' => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->orderBy('hotels.price', 'asc')
                                    ->offset(($page - 1) * $this->perPage)
                                    ->limit($this->perPage)
                                    ->get(), 'price-asc'],
                    'price-desc' => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->orderBy('hotels.price', 'desc')
                                    ->offset(($page - 1) * $this->perPage)
                                    ->limit($this->perPage)
                                    ->get(), 'price-desc'],            
                    default => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->orderBy('hotels.id', 'desc')
                                    ->offset(($page - 1) * $this->perPage)
                                    ->limit($this->perPage)
                                    ->get(), 'default']
                };
                $filter = 0;
            }
            else {
                $allCount = match($request->sort) {
                    'price-asc' => DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select(DB::raw('count(hotels.id) AS allHotels'))
                                    ->where('hotels.country_id', $request->country_id)
                                    ->first()->allHotels,
                    'price-desc' => DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select(DB::raw('count(hotels.id) AS allHotels'))
                                    ->where('hotels.country_id', $request->country_id)
                                    ->first()->allHotels,                    
                    default => DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select(DB::raw('count(hotels.id) AS allHotels'))
                                    ->where('hotels.country_id', $request->country_id)
                                    ->first()->allHotels,
                };

                $page = $request->page ?? 1;

                $hotelsDir = match($request->sort) {
                    'price-asc' => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->where('countries.id', $request->country_id)
                                    ->orderBy('hotels.price', 'asc')
                                    ->offset(($page - 1) * $this->perPage)
                                    ->limit($this->perPage)
                                    ->get(), 'price-asc'],
                    'price-desc' => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->where('countries.id', $request->country_id)
                                    ->orderBy('hotels.price', 'desc')
                                    ->offset(($page - 1) * $this->perPage)
                                    ->limit($this->perPage)
                                    ->get(), 'price-desc'],            
                    default => [DB::table('hotels')
                                    ->join('countries', 'countries.id', '=', 'hotels.country_id')
                                    ->select('countries.*', 'hotels.id', 'hotels.country_id', 'hotels.hotel_name', 'hotels.price' , 'hotels.image', 'hotels.trip_time')
                                    ->orderBy('hotels.id', 'desc')
                                    ->offset(($page - 1) * $this->perPage)
                                    ->limit($this->perPage)
                                    ->get(), 'default']
                };
                $filter = (int) $request->country_id;
            }
        }

        $parsedUrl = parse_url(url()->full());
        parse_str($parsedUrl['query'] ?? '', $prevQuery);        

        return view('hotel.index', [
            'hotels' => $hotelsDir[0],
            'sort' => $hotelsDir[1],
            'countries' => Country::all(),
            'filter' => $filter,
            's' => $request->s ?? '',
            'allCount' => $allCount ?? 0,
            'perPage' => $this->perPage ?? 0,
            'prevQuery' => $prevQuery,
            'pageNow' => $page ?? 0
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
        // $hotel->image = $request->create_hotel_image; 

        if ($request->file('create_hotel_image')) {
            $image = $request->file('create_hotel_image');
            $ext = $image->getClientOriginalExtension();
            $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $name. '-' . rand(100000, 999999). '.' . $ext;
            $image->move(public_path().'/images', $file);
            $hotel->image = asset('/images') . '/' . $file;
        }

        $hotel->trip_time = $request->create_hotel_trip_time;

        $hotel->save();

        return redirect()->route('hotels-index')->with('success', 'Created new hotel!');
    }

    public function order(int $hotel_Id)
    {
        $hotel = Hotel::where('id', $hotel_Id)->first();

        $order = new Order;
        $order->hotel_id = $hotel->id;
        $order->user_id = Auth::user()->id;

        $order->save();

        return redirect()->route('orders-index')->with('success', 'Order added!');
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
    public function edit(int $hotel_Id)
    {
        $countries = Country::all();
        $hotel = Hotel::where('id', $hotel_Id)->first();

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
        // $hotel->image = $request->hotel_image;
        if ($request->file('hotel_image')) {

            $name = pathinfo($hotel->image, PATHINFO_FILENAME);
            $ext = pathinfo($hotel->image, PATHINFO_EXTENSION);
    
            // $path = asset('/images') . '/' . $name . '.' . $ext;
            $path = '\xampp\htdocs\hotel\public/images' . '/' . $name . '.' . $ext;
            if (file_exists($path)) {
                unlink($path);
            }
            $image = $request->file('hotel_image');
            $ext = $image->getClientOriginalExtension();
            $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $file = $name. '-' . rand(100000, 999999). '.' . $ext;
            $image->move(public_path().'/images', $file);
            $hotel->image = asset('/images') . '/' . $file;
        }
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
    public function destroy(int $hotel_Id)
    {
        $allOrders = DB::table('orders')
                    ->join('hotels', 'hotels.id', '=', 'orders.hotel_id')
                    ->select(DB::raw('count(orders.id) AS allOrders'))
                    ->where('orders.hotel_id', $hotel_Id)
                    ->first()->allOrders;

        if ($allOrders > 0) {
            return redirect()->route('hotels-index')->with('error', 'Hotel has orders!');
        }

        $hotel = Hotel::where('id', $hotel_Id)->first();

        if ($hotel->image) {
            $name = pathinfo($hotel->image, PATHINFO_FILENAME);
            $ext = pathinfo($hotel->image, PATHINFO_EXTENSION);
            // $path = asset('/images') . '/' . $name . '.' . $ext;
            $path = '\xampp\htdocs\hotel\public/images' . '/' . $name . '.' . $ext;
            if (file_exists($path)) {
                unlink($path);
            }
        }
        

        $hotel->delete();

        return redirect()->route('hotels-index')->with('delete', 'Hotel deleted!');
    }

    public function deletePicture(Hotel $hotel) 
    {
        $name = pathinfo($hotel->image, PATHINFO_FILENAME);
        $ext = pathinfo($hotel->image, PATHINFO_EXTENSION);

        $path = asset('/images') . '/' . $name . '.' . $ext;

        if(file_exists($path)) {
            unlink($path);
        }
        
        $hotel->image = null;
        $hotel->save();

        return redirect()->back()->with('deleted', 'Hotel have no photo now');
    }
}
