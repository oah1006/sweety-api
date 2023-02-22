<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CreateCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $customer = Customer::query();

        $keyword = $request->keyword;

        $customer->when($keyword, fn (Builder $query)
                    => $query->whereFullText('full_name', $keyword))
                 ->orWhere('code', $keyword)
                 ->orWhereHas('user', fn (Builder $query)
                    => $query->whereFullText(['address', 'phone_number'], $keyword));



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
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCustomerRequest $request)
    {
        $data = $request->validated();

        do {
            $data['code'] = 'KH' . fake()->randomNumber(5, false);
        } while (Customer::where('code', $data['code'])->exists());

        $data['password'] = bcrypt($data['password']);

        $customer = Customer::create($data);

        $customer->user()->create($data);

        return response()->json([
            'data' => $customer
        ], 201);
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
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->validated();

        $customer->update($request->safe()->only(
            (new Customer)->getFillable()
        ));

        $customer->user()->update($request->safe()->only(
            (new User)->getFillable()
        ));

        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->noContent();
    }
}
