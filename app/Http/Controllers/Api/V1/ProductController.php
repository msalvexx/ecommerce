<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Product;
use App\Models\ProductType;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return $product->applyFilters()->applySort()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\Product\StoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Product $product, ProductType $type)
    {
        //Set product type relation
        $type = $type->firstOrCreate(['name' => $request->input('type')]);
        $product->type()->associate($type);

        //Fill all attributes
        $product = $product->fill($request->all());

        $product->save();

        return $product;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Resources\Product\UpdateRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $product, ProductType $type)
    {
        //Set product type relation if needs
        if($request->has('type')) {
            $type = $type->firstOrCreate(['name' => $request->input('type')]);
            $product->type()->associate($type);
        }

        return $product->update($request->all()) ? $product : 404;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return $product->delete() ? 204 : 404;
    }
}
