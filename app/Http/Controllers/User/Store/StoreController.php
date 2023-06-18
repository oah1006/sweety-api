<?php

namespace App\Http\Controllers\User\Store;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $stores = Store::with('address', 'address.ward', 'address.province', 'address.district');

        $keywords = $request->keywords;

        $stores->when($keywords, fn (Builder $query)
            => $query->whereFullText(['store_name'], $keywords)
            ->orWhereHas('address.district', fn(Builder $query)
                => $query->whereFullText(['name', 'full_name'], $keywords)
            ->orWhereHas('address.ward', fn(Builder $query)
                => $query->whereFullText(['name', 'full_name'], $keywords)
            ->orWhereHas('address.province', fn(Builder $query)
                => $query->whereFullText(['name', 'full_name'], $keywords)))));

        if ($request->filled('province_code')) {
            $provinceCode = $request->province_code;

            $stores->whereRelation('address.province',  function ($query) use ($provinceCode) {
                $query->where('province_code', $provinceCode);
            });
        }

        $stores = $stores->get();

        return response()->json([
            'data' => $stores
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
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
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
