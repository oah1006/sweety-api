<?php

namespace App\Http\Controllers\Admin\Topping;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Topping\CreateToppingRequest;
use App\Http\Requests\Admin\Topping\UpdateToppingRequest;
use App\Models\Topping;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $toppings = Topping::query();

        $keywords = $request->keywords;

        $toppings->when($keywords, fn (Builder $query)
                => $query->whereFullText('name', $keywords));


        if ($request->filled('published')) {
            $published = $request->published;

            $toppings->where('published', $published);
        }

        $toppings = $toppings->paginate();

        return response()->json([
            'data' => $toppings
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
    public function store(CreateToppingRequest $request)
    {
        $data = $request->validated();

        $topping = Topping::create($data);

        return response()->json([
            'topping' => $topping
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateToppingRequest $request, Topping $topping)
    {
        $data = $request->validated();

        $topping->update($data);

        return response()->json([
            'data' => $topping
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Topping $topping)
    {
        $topping->delete();

        return response()->noContent();
    }
}
