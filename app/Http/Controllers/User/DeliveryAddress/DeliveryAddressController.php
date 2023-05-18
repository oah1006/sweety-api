<?php

namespace App\Http\Controllers\User\DeliveryAddress;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DeliveryAddress\ChangeIsDefaultDeliveryAddressRequest;
use App\Http\Requests\Admin\DeliveryAddress\CreateAddressRequest;
use App\Http\Requests\Admin\DeliveryAddress\UpdateAddressRequest;
use App\Models\Address;
use App\Models\Customer;
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
        $old_delivery_addresses = auth()->user()->profile->address;

        $delivery_addresses = [$old_delivery_addresses->where('is_default', 1)->first()];

        $un_default_delivery_addresses = $old_delivery_addresses->where('is_default', 0)->values();

        foreach($un_default_delivery_addresses as $un_default_delivery_address) {
            array_push($delivery_addresses, $un_default_delivery_address);
        }

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
    public function store(CreateAddressRequest $request, Customer $customer)
    {
        $data = $request->validated();

        $delivery_address = auth()->user()->profile->address;

        if (count($delivery_address) < 5) {
            $delivery_addresses = auth()->user()->profile->address()->update([
                'is_default' => 0
            ]);

            $address = $customer->address()->create($data);
        } else {
            return response()->json([
                'message' => 'Vượt quá địa chỉ giao hàng quy định'
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
        if ($delivery_address->is_default == 1) {
            $delivery_address->delete();

            auth()->user()->profile->address()->first()->update([
                'is_default' => '1'
            ]);
        } else {
            $delivery_address->delete();
        }
        return response()->noContent();
    }

    public function changeIsDefault(ChangeIsDefaultDeliveryAddressRequest $request, Address $address) {
        $delivery_addresses = auth()->user()->profile->address()->update([
            'is_default' => 0
        ]);

        $address->is_default = 1;

        $address->save();

        return response()->noContent();
    }

    public function getCoordinates(Request $request) {
        $streetNumber = $request->query('streetNumber');
        $street = $request->query('street');
        $district = $request->query('district');
        $province = $request->query('province');

        $response = Http::get("https://api.tomtom.com/search/2/structuredGeocode.json?key=8G20bE5y7PQbBlAbMlAU6q6IEuKUhI33&streetNumber={$streetNumber}&streetName={$street}&municipalitySubdivision={$district}&countrySubdivision={$province}&countryCode=VN");

        return response()->json($response->json());
    }
}
