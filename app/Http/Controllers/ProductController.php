<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Requests\ProductRequest;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }
    public function index()
    {
        return ProductCollection::collection(Product::paginate(5));
    }


    public function store(ProductRequest $request)
    {
        $product = new Product([
            'name' => $request->input('name'),
            'detail' => $request->input('description'),
            'stock' => $request->input('stock'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
        ]);

        $product->save();
        return response()->json([
            'success' => true,
            'message' => 'Products Success Inserted!',
            'data' => [
                'type' => $product->typeKey(),
                'id'   => $product->id,
                'attributes' => new ProductResource($product)
            ],

        ], Response::HTTP_CREATED);
    }


    public function show(Product $product)
    {
        return new ProductResource($product);
    }


    public function update(Request $request, Product $product)
    {
        //change description to detail
        $request['detail'] = $request->description;
        unset($request['description']);
        if($product->update($request->all())){
            return response()->json([
                'success' => true,
                'message' => 'Product Updated',
                'data' => [
                    'type' => $product->typeKey(),
                    'id' => $product->id,
                    'attributes' => new ProductResource($product),
                ]
            ]);
        };

    }


    public function destroy(Product $product)
    {
        //
    }
}
