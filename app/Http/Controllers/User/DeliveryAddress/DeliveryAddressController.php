<?php

namespace App\Http\Controllers\User\DeliveryAddress;

use App\Actions\CalculationRoute;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\DeliveryAddress\CreateAddressRequest;
use App\Http\Requests\User\DeliveryAddress\UpdateAddressRequest;
use App\Models\Address;
use App\Models\District;
use App\Models\Province;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class DeliveryAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $delivery_addresses = auth()->user()->profile->address->all();

        return response()->json([
            'data' => $delivery_addresses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAddressRequest $request)
    {
        $data = $request->validated();

        $delivery_address = auth()->user()->profile->address;

        $stores = Store::with('address')->get();


        if ($delivery_address->count() < 5) {
            $address = auth()->user()->profile->address()->create($data);

            $meta = [];

            foreach($stores as $store) {
                $longStore = $store->address->long;
                $latStore = $store->address->lat;

                $longAddress = $address->long;
                $latAddress = $address->lat;

                $meta[] = ["store_id" => $store->id, "location" => (CalculationRoute::run($latAddress, $longAddress, $latStore, $longStore) / 1000)];
            }

            $address->meta = $meta;

            $address->save();

        } else {
            return response()->json([
                'message' => 'Hệ thống chỉ cho phép tạo 5 địa chỉ. Vui lòng cập nhật hoặc xóa địa chỉ!'
            ], 401);
        }

        return response()->json([
            'data' => $address
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Address $delivery_address)
    {
        return response()->json([
            'data' => $delivery_address
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAddressRequest $request, Address $delivery_address)
    {
        $data = $request->validated();

        $delivery_address->update($data);

        return response()->json([
            'data' => $delivery_address
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $delivery_address)
    {
        $delivery_address->delete();

        return response()->noContent();
    }

    public function calculationRoute(Request $request) {
        $latBegin = $request->query('latBegin');
        $longBegin = $request->query('longBegin');

        $latEnd = $request->query('latEnd');
        $longEnd = $request->query('longEnd');

        $response = Http::get("https://api.tomtom.com/routing/1/calculateRoute/{$latBegin},{$longBegin}:{$latEnd},{$longEnd}/json?instructionsType=text&language=en-US&vehicleHeading=90&sectionType=traffic&report=effectiveSettings&routeType=eco&traffic=true&avoid=unpavedRoads&travelMode=car&vehicleMaxSpeed=120&vehicleCommercial=false&vehicleEngineType=combustion&key=8G20bE5y7PQbBlAbMlAU6q6IEuKUhI33");

        return response()->json($response->json());
    }

    public function getCoordinates(Request $request) {
        $streetNumber = $request->query('streetNumber');
        $street = $request->query('street');
        $district = $request->query('district');
        $province = $request->query('province');

        $nameDistrict = District::where('code', $district)->first()->full_name;
        $nameProvince = Province::where('code', $province)->first()->full_name;

        $response = Http::get("https://api.tomtom.com/search/2/structuredGeocode.json?key=8G20bE5y7PQbBlAbMlAU6q6IEuKUhI33&streetNumber={$streetNumber}&streetName={$street}&municipalitySubdivision={$nameDistrict}&countrySubdivision={$nameProvince}&countryCode=VN");

        return response()->json($response->json());
    }

    public function chooseMyDeliveryAddressOrder(Request $request, Address $address) {
        $user = $request->user();

        $cart = $user->profile->cart;

        $cart->update([
            'address_id' => $address->id
        ]);

        $cart = $cart->fresh();

        $cart->calculateShippingFee();

        $cart->save();
    }
}
