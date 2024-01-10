<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Products;
use App\Http\Requests\ProductsStoreRequest;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Products::all();

        return response()->json([
            'results' => $products,
        ], 200);
    }

    public function store(ProductsStoreRequest $request)
    {
        $existingProduct = Products::where('name', $request->name)->first();

        if ($existingProduct) {
            return response()->json([
                'message' => 'Product already registered.'
            ], 400);
        }

        try {
            Products::create([
                'name' => $request->name,
                'description' => $request->description,
                'length' => $request->length,
                'height' => $request->height,
                'depth' => $request->depth,
                'weight' => $request->weight,
                'photo' => $request->photo,
                'id_company' => $request->id_company,
            ]);

            return response()->json([
                'message' => 'Product successfully created.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went really wrong!'
            ], 500);
        }
    }

    public function show($id)
    {
        $products = Products::find($id);

        if (!$products) {
            return response()->json([
                'message' => 'Product Not Found.'
            ], 404);
        }

        return response()->json([
            'products' => $products
        ], 200);
    }

    public function update(ProductsStoreRequest $request, $id)
    {
        try {
            $products = Products::find($id);

            if (!$products) {
                return response()->json([
                    'message' => 'Product Not Found.'
                ], 404);
            }

            $products->name = $request->name;
            $products->description = $request->description;
            $products->lenght = $request->lenght;
            $products->height = $request->height;
            $products->depth = $request->depth;
            $products->weight = $request->weight;
            $products->photo = $request->photo;
            $products->id_company = $request->id_company;

            $products->save();

            return response()->json([
                'message' => 'Product successfully updated.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Something went really wrong!'
            ], 500);
        }
    }

    public function destroy($id)
    {
        $products = Products::find($id);

        if (!$products) {
            return response()->json([
                'message' => 'Product Not Found.'
            ], 404);
        }

        $products->delete();

        return response()->json([
            'message' => 'Product successfully deleted.'
        ], 200);
    }
}
