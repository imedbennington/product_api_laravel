<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
class ProductController extends Controller
{
    //product listing
    public function index (Request $request){
        $products = Product::all();
        return response()->json([
            'status'=>true,
            'message'=>'Listed products',
            'data'=>$products
        ],200);
    }
//create product
    public function create (Request $request){

        $validateProduct = Validator::make($request->all(), [
            'prod_name' => 'required|unique:products,prod_name',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric'
        ]);
    
        if ($validateProduct->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'data' => $validateProduct ->errors()
                
            ], 422);
        }

        $inputData = array(
            'prod_name'=>$request->prod_name,
            'quantity'=>$request->quantity,
            'price'=>$request->price,
            'description'=>isset($request->description)? $request->description : ''
        );

        $product = Product::create($inputData);
        return response()->json([
            'status'=>true,
            'message'=>'Product added ',
            'data'=>$product
        ],200);
    }

    //update product

    public function update (Request $request){

        $validateProduct = Validator::make($request->all(), [
            'id' => 'required|exists:products,id',
            'prod_name' => 'required|unique:products,prod_name',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric'
        ]);
    
        if ($validateProduct->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'validation error',
                'data' => $validateProduct ->errors()
                
            ], 422);
        }

        $product = Product::find($request->id);
        $product->prod_name = $request->prod_name;
        $product->quantity = $request->quantity;
        $product->price = $request->price;
        $product->description = $request->description ?? '';
        $product->save();
        return response()->json([
            'status'=>true,
            'message'=>'Product updated ',
            'data'=>$product
        ],200);
    }

    //delete product

    public function delete($id)
    {
        // Validation
        $validateProduct = Validator::make(['id' => $id], [
            'id' => 'required|exists:products,id',
        ]);
    
        if ($validateProduct->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'data' => $validateProduct->errors()
            ], 422);
        }
    
        // Find product by ID
        $product = Product::find($id);
    
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found'
            ], 404);
        }
    
        // Delete the product
        $product->delete();
    
        return response()->json([
            'status' => true,
            'message' => 'Product deleted',
            'data' => $product
        ], 200);
    }
    
    
        }
    

