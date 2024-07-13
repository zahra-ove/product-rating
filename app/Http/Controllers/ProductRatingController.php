<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductRatingResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ProductRatingController extends Controller
{
    /**
     * Display list of all ratings for specific product
     */
    public function index(int $product_id)
    {
        $result = ProductRating::where('product_id', $product_id)->get();

        return response()->json([
            'product' => new ProductResource(Product::findOrFail($product_id)),
            'data'    => ProductRatingResource::collection($result)
        ]);
    }

    /**
     * Store a newly rated product-attribute
     */
    public function store(Request $request)
    {
        // validate data
        $validator = Validator::make($request->all(), [
            'product_id'           => ['required', 'numeric', 'exists:products,id'],
            'product_attribute_id' => ['required', 'numeric', 'exists:product_attributes,id'],
            'rate'                 => ['required', 'min:0', 'max:100', 'between:0,100'],
            'user_id'              => ['required','numeric']
        ]);

        // if validation failed
        if ($validator->fails()) {
            return response()->json([
                'messsage' => 'error',
                'errors' => $validator->errors()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }


        // save validated data
        $validatedData = $validator->validated();
        $result = ProductRating::create($validatedData);

        return response()->json([
            'messsage' => 'success',
            'data'     => $result
        ], Response::HTTP_CREATED);
    }

    /**
     * Display list of all rating for given product and given attribute
     */
    public function show(int $product_id, int $product_attribute_id)
    {
        // check if wanted record exists in db
        if(! ProductRating::where(['product_id'=>$product_id, 'product_attribute_id'=>$product_attribute_id])->exists()) {
            return response()->json([
                'message' => 'failed'
            ], Response::HTTP_NOT_FOUND);
        }


        $result = ProductRating::where(['product_id'=>$product_id, 'product_attribute_id'=>$product_attribute_id])->pluck('rate');

        return response()->json([
            'product' => new ProductResource(Product::findOrFail($product_id)),
            'data'    => $result
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // validate data
        $validator = Validator::make($request->all(), [
            'product_id'           => ['required', 'numeric'],
            'product_attribute_id' => ['required', 'numeric'],
            'rate'                 => ['required', 'min:0', 'max:100', 'between:0,100'],
            'user_id'              => ['required', 'numeric']
        ]);

        // if validation failed
        if ($validator->fails()) {
            return response()->json([
                'messsage' => 'error',
                'errors' => $validator->errors()],
                Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // update validated data
        $validatedData = $validator->validated();

        // check if wanted record exists in db
        if(! ProductRating::where(['product_id'=>$validatedData['product_id'], 'product_attribute_id'=>$validatedData['product_attribute_id']])->exists()) {
            return response()->json([
                'message' => 'failed'
            ], Response::HTTP_NOT_FOUND);
        }



        ProductRating::where(['product_id'=>$validatedData['product_id'],
                                'product_attribute_id'=>$validatedData['product_attribute_id'],
                                'user_id'=>$validatedData['user_id']])
                                ->update(['rate'=> $validatedData['rate']]);

        return response()->json([
            'messsage' => 'success',
        ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // check if record exists
        if(! ProductRating::where('id', $id)->exists($id)) {
            return response()->json([
                'messsage' => 'failed',
            ], Response::HTTP_NOT_FOUND);
        }

        $result = ProductRating::where('id', $id)->delete();

        // if not deleted
        if(! $result) {
            return response()->json([
                'messsage' => 'failed',
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // if delete was successful
        return response()->json([
            'messsage' => 'success',
        ], Response::HTTP_NO_CONTENT);

    }
}
