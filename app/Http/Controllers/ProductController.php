<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use PhpOption\None;

class ProductController extends Controller
{

    public function view_dashboard(Request $request)
    {
        $transaction = $request->user()->store->transactions()->whereDate('created_at', now())->get();  //gets today's transaction
        $today_total = $transaction->sum('Total_Amount');

        $records = $request->user()->store->transactions()->whereBetween('created_at', [   //gets transaction from first day of week
            Carbon::now()->startOfWeek(), 
            Carbon::now()
        ])->get();
        $weekly_total = $records->sum('Total_Amount');

        $transaction_total = $request->user()->store->transactions()->count();       


        $graph_data = [];
        for ($i=0; $i < 7; $i++) {
            $transaction = $request->user()->store->transactions()->whereDate('created_at', now()->startOfWeek()->addDays($i))->get();
            $graph_data[] = $transaction->sum('Total_Amount');
        }

        return view('dashboard', [
            'today_sale'=> $today_total,
            'weekly_sale'=> $weekly_total,
            'transaction_total'=> $transaction_total,
            'graph_data'=> $graph_data
        ]);
    }

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
        $buying_price = $request->input('cost');
        $selling_price = $request->input('price');
        $category_id = $request->input('category');
        $new_category = $request->input('new_category');

        if ($new_category) {
            $new_cat = $request->user()->store->categories()->create([
                'name' => $new_category
            ]);
            $request->user()->store->products()->create([
                'name' => $name,
                'buying_price' => $buying_price,
                'selling_price' => $selling_price,
                'category_id' => $new_cat->id,
            ]);
        } else {
            $request->user()->store->products()->create([
                'name' => $name,
                'buying_price' => $buying_price,
                'selling_price' => $selling_price,
                'category_id' => $category_id,
            ]);
        }
        return redirect()->route('products');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $name = $request->input('name');
        $selling_price = $request->input('price');
        $buying_price = $request->input('cost');
        $category_id = $request->input('category');

        $request->user()->store->products()->where('id', '=', $id)->update([ 
            'name' => $name,
            'selling_price' => $selling_price,
            'buying_price' => $buying_price,
            'category_id'=> $category_id,
        ]);
        return redirect()->route('products');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $cat_id = $request->user()->store->products->find($id)->category_id;
        $cat = $request->user()->store->categories()->find($cat_id);
        $request->user()->store->products()->where('id', '=', $id)->delete();
        if ($cat->products()->count() <= 0) {
            $cat->delete();
        }
        return redirect()->route('products');
    }

    public function view_checkout_page() 
    {
        return view('checkout');
    }

    public function get_localstorage_data(Request $request)
    {
        $cart_id_list = $request->input('lS_data');
        $cart_data = [];
        foreach ($cart_id_list as $item) {
            $data = $request->user()->store->products()->find($item['id']);
            $cart_data[] = $data;
        };
        return $cart_data;
    }

    public function make_receipt(Request $request)
    {
        $cart_list = $request->input('final_ls');
        $discount = array_pop($cart_list);
        $paid_amount = array_pop($cart_list);

        $total = 0;
        $transaction = $request->user()->store->transactions()->create([
            'Total_Amount' => $total,
            'Discount' => $discount,
            'Paid_Amount' => $paid_amount
        ]);

        foreach ($cart_list as $item) {
            $data = $request->user()->store->products()->find($item['id']);
            $subtotal = $data->selling_price * $item['quantity'];
            $total += $subtotal;

            $item = $transaction->items()->create([
                'product_name' => $data->name,
                'product_price' => $data->selling_price,
                'product_quantity' => $item['quantity'],
                'subtotal' => $subtotal
            ]);
        };

        $transaction->Total_Amount = $total;
        $transaction->save();
        return $transaction->id;
    }

    public function view_transactions_history(Request $request)
    {
        $transaction_history = $request->user()->store->transactions;
        return view('transactions', [
            'transactions' => $transaction_history
        ]);
    }

    public function view_transaction(Request $request, String $id)
    {
        $transaction = $request->user()->store->transactions->find($id);
        $items = $transaction->items;
        
        return view('transaction', ['transaction'=>$transaction, 'items'=>$items]);
        
    }
}