<?php

namespace App\Http\Controllers\Address;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryAddress\CreateAddressRequest;
use App\Http\Requests\DeliveryAddress\UpdateAddressRequest;
use App\Models\Customer;
use App\Models\Address;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateAddressRequest $request, Customer $customer)
    {
        $data = $request->validated();

        $address = $customer->address()->create($data);

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
    public function show($id)
    {
        //
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
    public function update(UpdateAddressRequest $request, Customer $customer, $id)
    {
        $data = $request->validated();

        $address = $customer->address()->findOrFail($id);

        $address->update($data);

        return response()->noContent();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
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

        $response = Http::get("https://api.tomtom.com/search/2/structuredGeocode.json?key=8G20bE5y7PQbBlAbMlAU6q6IEuKUhI33&streetNumber={$streetNumber}&streetName={$street}&municipalitySubdivision={$district}&countrySubdivision={$province}&countryCode=VN");

        return response()->json($response->json());
    }
}
