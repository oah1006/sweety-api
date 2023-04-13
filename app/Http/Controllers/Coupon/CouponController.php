<?php

namespace App\Http\Controllers\Coupon;

use App\Http\Controllers\Controller;
use App\Http\Requests\Coupon\StoreCouponRequest;
use App\Http\Requests\Coupon\UpdateCouponRequest;
use App\Models\Coupon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $coupons = Coupon::where('is_deleted', 0);

        $keywords = $request->keywords;

        $coupons->when($keywords, fn (Builder $query)
        => $query->whereFullText(['name', 'description'], $keywords));

        if ($request->filled('status')) {
            $status = $request->status;

            $coupons->where('status', $status);
        }

        $coupons = $coupons->paginate(4);

        return response()->json([
            'data' => $coupons
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
    public function store(StoreCouponRequest $request)
    {
        $this->authorize('create', Coupon::class);

        $data = $request->validated();

        $coupon = Coupon::create($data);

        return response()->json([
            'data' => $coupon
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Coupon $coupon)
    {
        return response()->json([
            'data' => $coupon
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
    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $this->authorize('update', $coupon);

        $data = $request->validated();

        $coupon->update($data);

        return response()->json([
            'data' => $coupon
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Coupon $coupon)
    {
        $this->authorize('delete', $coupon);

        $coupon->is_deleted = 1;

        $coupon->save();

        return response()->noContent();
    }
}
