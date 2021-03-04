<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

class ProductController extends ApiController
{
  public function __construct()
  {
    $this->middleware('auth:api');
  }
  
  public function index()
  {
    $products = Product::with('category')->get();

    return $this->showResponse($products);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(ProductStoreRequest $request)
  {
    
    $data = $request->all();
    $data['image'] = $request->image->store('');
    
    $product = Product::create($data);

    return $this->showResponse($product, 201);

  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
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
  public function update(ProductUpdateRequest $request, Product $product)
  {
    $product->fill($request->except('image'));

    if($request->hasFile('image')) {
      Storage::delete($product->image);

      $product->image = $request->image->store('');
    }

    $product->save();

    return $this->showResponse($product, 204);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Product $product)
  {
    Storage::delete($product->image);
     
    $product->delete();

    return $this->showResponse($product, 204);
  }
  
}
