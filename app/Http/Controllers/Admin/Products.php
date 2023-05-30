<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class Products extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();
        return view('admin.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $validated = $request->validated();
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'custom_name.'.substr(time(),-5).'.'.$file->getClientOriginalExtension();
            $file->storeAs('images', $fileName, 'public');
            $validated['image'] = $fileName;
        }
        $products = new Product;
        if($products->insert($validated))
        {
            return redirect()->route('admin.products.index')->with('success','Product Added successfully');
        }
        
        return redirect()->back()->with('failure','Something went wrong, please try later');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit',compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->description = $request->description;
        $product->status = $request->status;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'custom_name.'.substr(time(),-5).'.'.$file->getClientOriginalExtension();
            $file->storeAs('images', $fileName, 'public');
            $product['image'] = $fileName;
        }
        if($product->save())
        {
            return redirect()->route('admin.products.index')->with('success','Product Updated successfully');
        }
        return redirect()->back()->with('failure','Something went wrong, please try later');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->delete())
        {
            return redirect()->route('admin.products.index')->with('success','Product rempoved successfully');
        }
        return redirect()->back()->with('failure','Something went wrong, please try later');
    }
}
