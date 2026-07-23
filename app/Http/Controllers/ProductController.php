<?php

namespace App\Http\Controllers;

use App\Models\ProductDatabase;
use App\Models\transactions;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /** 
     * Display Product Page
     */
    public function get_product_page(Request $request)
    {
        $products = $request->user()->store->products;
        $categories = $request->user()->store->categories;
        return view('products', [ 'products' => $products, 'category'=> $categories ]); 
    }


    /**
     * Create New Category / If Exist, Create New Product
     */
    public function create_new_product(Request $request)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $category_id = $request->input('category');
        $new_category = $request->input('new_category');
        $stock = $request->input('stock');

        if ($new_category) {
            $new_cat = $request->user()->store->categories()->create([
                'name' => $new_category
            ]);
            $request->user()->store->products()->create([
                'name' => $name,
                'price' => $price,
                'category_id' => $new_cat->id,
                'stock' => $stock
            ]);
        } else {
            $request->user()->store->products()->create([
                'name' => $name,
                'price' => $price,
                'category_id' => $category_id,
                'stock' => $stock
            ]);
        }
        return redirect(route('products'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->input('name');
        $price = $request->input('price');
        $category_id = $request->input('category');
        $stock = $request->input('stock');

        $request->user()->store->products()->where('id', '=', $id)->update([ 
            'name' => $name,
            'price' => $price,
            'category_id'=> $category_id,
            'stock' => $stock
        ]);
        return redirect(route('products'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $request->user()->store->products()->where('id', '=', $id)->delete();
        return redirect(route('products'));
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
