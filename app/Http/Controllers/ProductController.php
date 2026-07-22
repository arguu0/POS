<?php

namespace App\Http\Controllers;

use App\Models\ProductDatabase;
use App\Models\transactions;
use Illuminate\Http\Request;

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
    public function create(Request $request)
    {
        $cat = $request->user()->store->categories;
        return view('create', [ 'cat'=>$cat ]);
    }

    public function create_cat(Request $request)
    {
        $category = $request->input('cat_name');
        $request->user()->store->categories()->create([
            'name' => $category
        ]);
        return redirect('/products/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $product_name = $request->input('name');
        $price = $request->input('price');
        $category_id = $request->input('category');

        $request->user()->store->products()->create([
            'name' => $product_name,
            'price' => $price,
            'category_id' => $category_id
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
    public function edit(Request $request, string $id)
    {
        $product_detail = $request->user()->store->products->findOrFail($id);

        return view('update', ['user'=> $product_detail->name, 
                                'price'=> $product_detail->price, 
                                'cat'=>$request->user()->store->categories->except($product_detail->category_id), 
                                'sel_cat_id'=> $product_detail->category_id, 
                                'sel_cat_name'=>$request->user()->store->categories->findOrFail($product_detail->category_id)->name,  
                                'id'=>$id]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $category_id = $request->input('category');
        $request->user()->store->products()->where('id', '=', $id)->update([ 
            'name' => $name,
            'price' => $price,
            'category_id'=> $category_id
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

    public function view_cart() 
    {
        return view('cart');
    }

    public function return_product_data (Request $request)
    {
        $products = $request->user()->store->products;
        return $products;
    }

    public function create_transaction_history(Request $request)
    {
        $length = $request->input('length');
        $total = 0;
        $items = [];
        for ($i=0; $i < $length ; $i++) { 
            $id = $request->input('id-' . $i);
            $qty = $request->input('qty-' . $i);
            $product = $request->user()->store->products()->find($id);
            $subtotal = $product->price * $qty;
            $total += $subtotal;

            $items[] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $qty,
                'subtotal' => $subtotal
            ];
        };

        $transaction = $request->user()->store->transactions()->create([
            'Total_Amount'=> $total
        ]);

        foreach ($items as $item) {
            $transaction->items()->create([
                'product_name' => $item['name'],
                'product_price' => $item['price'],
                'product_quantity' => $item['quantity'],
                'subtotal' => $item['subtotal']
            ]);
        }
        return redirect()->route('receipt.show', $transaction->id);
    }

    public function view_receipt(Request $request, string $id)
    {
        $transaction = $request->user()->store->transactions->find($id);
        $item = $transaction->items;
        return view('receipt', [ 'transaction' => $item, 'Total' => $transaction->Total_Amount ]);
    }

}
