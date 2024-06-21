<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
route::get('products',[ProductController::class,"index"]);
route::post('create_products',[ProductController::class,"create"]);
route::post('update_products',[ProductController::class,"update"]);
Route::delete('delete_products/{id}', [ProductController::class, 'delete']);

/*
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
*/