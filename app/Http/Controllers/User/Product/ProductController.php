<?php

namespace App\Http\Controllers\User\Product;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $products = Product::where('is_deleted', 0)->where('published', 1)->with(['category', 'productToppings']);

        $keywords = $request->keywords;

        $products->when($keywords, fn (Builder $query)
            => $query->whereFullText(['name', 'description'], $keywords));

        if ($request->price_low_to_high) {
            $products->orderBy('price', 'asc');
        }

        if ($request->price_high_to_low) {
            $products->orderBy('price', 'desc');
        }

        if ($request->category_id) {
            $categoryId = $request->category_id;

            $products->where('category_id', $categoryId);
        }

        $products = $products->paginate(6);

        return response()->json([
            'data' => $products
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
    public function show(Product $product)
    {
        $product->load(['attachment', 'category', 'productToppings', 'productVariants']);

        return response()->json([
            'data' => $product
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


    public function indexBestSeller(Request $request) {
        $bestSellingProducts = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'succeed')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

        $productIds = $bestSellingProducts->pluck('product_id');

        $products = Product::whereIn('id', $productIds)->where('published', 1)->get();

        return response()->json([
            'data' => $products
        ]);
    }

    public function indexRelatedProduct(Request $request, Category $category, Product $product) {
        $product = Product::where('category_id', $category->id)->where('published', 1)->whereNot('id', $product->id)->get();

        return response()->json([
            'data' => $product
        ]);
    }
}
