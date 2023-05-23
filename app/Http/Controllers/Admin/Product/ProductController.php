<?php

namespace App\Http\Controllers\Admin\Product;

use App\Actions\UploadAttachmentAction;
use App\Enums\AttachmentTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\StoreProductRequest;
use App\Http\Requests\Admin\Product\UpdateProductRequest;
use App\Models\Product;
use App\Models\Topping;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $products = Product::where('is_deleted', 0)->with('category');

        $keywords = $request->keywords;

        $products->when($keywords, fn (Builder $query)
                => $query->whereFullText(['name', 'description'], $keywords));

        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;

            $products->where('category_id', $categoryId);
        }

        if ($request->filled('published')) {
            $published = $request->published;

            $products->where('published', $published);

        }

        $products = $products->paginate(4);

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);

        $data = $request->validated();

        $product = Product::create($data);

        foreach($data['toppings'] as $item) {
            $product->productToppings()->create([
                'product_id' => $product->id,
                'topping_id' => $item,
            ]);
        }

        if ($request->hasFile('thumbnail')) {
            UploadAttachmentAction::run([$request->file('thumbnail')], $product, AttachmentTypes::THUMBNAILS);
        }

        if ($request->hasFile('detail_products')) {
            UploadAttachmentAction::run($request->file('detail_products'), $product, AttachmentTypes::DETAILPRODUCTS);
        }

        $product = $product->fresh();

        return response()->json([
            'data' => $data,
            'attachments' => $product->attachment
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $data = $request->validated();

        $product->update($data);

        $product->productToppings()->delete();

        foreach($data['toppings'] as $item) {
            $product->productToppings()->create([
                'product_id' => $product->id,
                'topping_id' => $item,
            ]);
        }

        $product->productVariants()->delete();

        foreach($data['variants'] as $item) {
            $product->productVariants()->create([
                'size' => $item['size'],
                'unit_price' => $item['unit_price']
            ]);
        }

        return response()->json([
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->is_deleted = 1;

        $product->save();

        return response()->noContent();
    }
}
