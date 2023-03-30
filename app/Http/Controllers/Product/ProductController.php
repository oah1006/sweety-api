<?php

namespace App\Http\Controllers\Product;

use App\Actions\UploadAttachmentAction;
use App\Enums\AttachmentTypes;
use App\Http\Controllers\Controller;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $products = Product::with('category');

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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $product = Product::create($data);

        if ($request->hasFile('thumbnail')) {
            UploadAttachmentAction::run([$request->file('thumbnail')], $product, AttachmentTypes::THUMBNAILS);
        }

        dump($request->hasFile('detail_products'));

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
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product->load('attachment');

        $product->load('category');

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
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $product->update($data);

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
        $product->delete();

        return response()->noContent();
    }
}
