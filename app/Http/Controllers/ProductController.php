<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductDatabase;
use App\Models\Store;
use App\Models\User;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = $request->user()->store->products;
        return view('products', [ 'products' => $products ]); 
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product_name = $request->input('name');
        $price = $request->input('price');
        
        $request->user()->store->products()->create([
            'name' => $product_name,
            'price' => $price,
        ]);
        return redirect('products');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('update', [ 'id'=>$id ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $request->user()->store->products()->where('id', '=', $id)->update([ 
            'name' => $name,
            'price' => $price,
        ]);
        return redirect('products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $request->user()->store->products()->where('id', '=', $id)->delete();
        return redirect('products');
    }
}
