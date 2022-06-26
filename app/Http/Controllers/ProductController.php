<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::with(['category', 'image'])->paginate(100);

        return ProductResource::collection($product);
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
    public function store(ProductStoreRequest $request)
    {


        $product =  Product::create($request->validated());


        if ($request->has('image')) {
            foreach ($request->file('image') as $file) {
                $filename =  uniqid() . '_' . trim($file->getClientOriginalName());

                $file->move(public_path('files/images/'), $filename);
                $path = '/files/images/' . $filename;
                $product->image()->create([
                    'name' => $filename,
                    'path' =>  $path,
                ]);
            }
        }

        return "Successfully Saved";
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return $product =  Product::with(['category', 'image'])->where('id', $id)->get();

        // return  ProductResource::collection($product);
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
    public function update(ProductStoreRequest $request, $id)
    {
        $product = Product::find($id);

        Product::where('id', $id)->update($request->validated());

        if ($request->has('image')) {
            foreach ($request->file('image') as $file) {
                $filename =  uniqid() . '_' . trim($file->getClientOriginalName());

                $file->move(public_path('files/images/'), $filename);
                $path = '/files/images/' . $filename;

                $product->image()->create([
                    'name' => $filename,
                    'path' =>  $path,
                ]);
            }
        }

        return "Successfully update";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);


        return "Product successfully removed";
    }
}
