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
                
            ], 400);
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
        }
    

