<?php

namespace App\Http\Controllers\Api\V1;

use App\Repositories\Product;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Repositories\Product  $repository
     * @return \Illuminate\Http\Response
     */
    public function index(Product $repository)
    {
        return response()->json($repository->list(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Requests\Product\StoreRequest  $request
     * @param  \App\Repositories\Product  $repository
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request, Product $repository)
    {
        return response()->json($repository->create($request->all()), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Repositories\Product  $repository
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $repository, $id)
    {
        return $repository->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Resources\Product\UpdateRequest  $request
     * @param  \App\Repositories\Product  $repository
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Product $repository, $id)
    {
        $response = $repository->update($id, $request->all());
        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Repositories\Product  $repository
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $repository, $id)
    {
        if($repository->delete($id)) {
            return response()->json(['No Content'], 204);
        }

        return response()->json(['Not Found'], 404);
    }
}
