<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use App\Http\Requests\Store\CreateStoreRequest;
use App\Http\Requests\Store\UpdateStoreRequest;
use App\Models\Store;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $stores = Store::query();

        $keywords = $request->keywords;

        $stores->when($keywords, fn (Builder $query)
            => $query->whereFullText(['name', 'address'], $keywords));

        $stores = $stores->paginate(4);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(CreateStoreRequest $request)
    {
        $this->authorize('create', Store::class);

        $data = $request->validated();

        $store = Store::create($data);

        return response()->json([
            'data' => $store
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Store $store)
    {
        return response()->json([
            'data' => $store
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
    public function update(UpdateStoreRequest $request, Store $store)
    {
        $this->authorize('update', $store);

        $data = $request->validated();

        $store->update($data);

        return response()->json([
            'data' => $store
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Store $store)
    {
        $this->authorize('delete', $store);

        $store->delete();

        return response()->noContent();
    }
}
