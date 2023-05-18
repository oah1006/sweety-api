<?php

namespace App\Http\Controllers\Admin\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Customer\CreateCustomerRequest;
use App\Http\Requests\Admin\Customer\UpdateCustomerRequest;
use App\Models\Address;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $customer = Customer::with(['user', 'address']);

        $keyword = $request->keywords;

        $customer->when($keyword, fn (Builder $query)
                    => $query->whereFullText('full_name', $keyword)
                 ->orWhere('code', $keyword)
                 ->orWhereHas('user', fn (Builder $query)
                    => $query->whereFullText(['address', 'phone_number', 'email'], $keyword)));

        $customer = $customer->paginate(4);

        return response()->json([
            'data' => $customer
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateCustomerRequest $request)
    {
        $this->authorize('create', Customer::class);

        $data = $request->validated();

        $customer = Customer::create($data);

        $customer->user()->create($data);

        $customer->address()->create($data);

        return response()->json([
            'data' => $customer
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Customer $customer)
    {
        $customer->load('user');

        $customer->load('address');

        return response()->json([
            'data' => $customer
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $this->authorize('update', $customer);

        $customer->update($request->safe()->only(
            (new Customer)->getFillable()
        ));

        $customer->user()->update($request->safe()->only(
            (new User)->getFillable()
        ));

        $customer->address()->update($request->safe()->only(
            (new Address)->getFillable()
        ));

        $customer = $customer->fresh();

        return response()->json([
            'data' => $customer
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $this->authorize('delete', $customer);

        $customer->delete();

        return response()->noContent();
    }
}
