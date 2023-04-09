<?php

namespace App\Http\Controllers\DeliveryAddress;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeliveryAddress\CreateDeliveryAddressRequest;
use App\Http\Requests\DeliveryAddress\UpdateDeliveryAddressRequest;
use App\Models\Customer;
use App\Models\DeliveryAddress;
use Illuminate\Http\Request;

class CustomerDeliveryAddressController extends Controller
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
    public function store(CreateDeliveryAddressRequest $request, Customer $customer)
    {
        $data = $request->validated();

        $delivery_address = $customer->deliveryAddresses()->create($data);

        return response()->json([
            'data' => $delivery_address
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
    public function update(UpdateDeliveryAddressRequest $request, Customer $customer, $id)
    {
        $data = $request->validated();

        $delivery_address = $customer->deliveryAddresses()->findOrFail($id);

        $delivery_address->update($data);

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
}
