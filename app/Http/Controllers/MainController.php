<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;


class MainController extends Controller
{

    public function view_dashboard(Request $request)
    {
        $transaction = $request->user()->store->transactions()->whereDate('created_at', now())->get();  //gets today's transaction
        $today_total = $transaction->sum('Total_Amount');
        $today_profit = $transaction->sum('Total_Profit');

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
            'graph_data'=> $graph_data,
            'today_profit' => $today_profit
        ]);
    }

    /** 
     * Display Product Page
     */
    public function get_product_page(Request $request)
    {
        $total_product = $request->user()->store->products->count();
        $categories = $request->user()->store->categories;

       
        if ($request->filled('category')) {
            $cat_name = $request->query('category');
            $filtered_cat = $request->user()->store->categories->where('name', $cat_name)->first();
            $products = $filtered_cat->products()->latest()->paginate(10);
        }
        elseif ($request->filled('search')) {
            $search_query = $request->query('search');
            $products = $request->user()->store->products()->where("name", "ILIKE", '%' . $search_query . '%')->paginate(10);
        }
        else {
            $products = $request->user()->store->products()->latest()->paginate(10);
        }
        
        return view('products', [ 'products' => $products, 'category'=> $categories, 'total_product'=>$total_product ]); 
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
        $profit = $selling_price - $buying_price;

        if ($new_category) {
            $new_cat = $request->user()->store->categories()->create([
                'name' => $new_category
            ]);
            $request->user()->store->products()->create([
                'name' => $name,
                'buying_price' => $buying_price,
                'selling_price' => $selling_price,
                'category_id' => $new_cat->id,
                'profit' => $profit
            ]);
        } else {
            $request->user()->store->products()->create([
                'name' => $name,
                'buying_price' => $buying_price,
                'selling_price' => $selling_price,
                'category_id' => $category_id,
                'profit' => $profit
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
        $profit = $selling_price - $buying_price;

        $request->user()->store->products()->where('id', '=', $id)->update([ 
            'name' => $name,
            'selling_price' => $selling_price,
            'buying_price' => $buying_price,
            'category_id'=> $category_id,
            'profit' => $profit
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
            $data = $request->user()->store->products()->select(['id', 'name', 'selling_price'])->find($item['id']);
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
        $total_profit = 0;
        $transaction = $request->user()->store->transactions()->create([
            'Total_Amount' => $total,
            'Discount' => $discount,
            'Paid_Amount' => $paid_amount,
            'Total_Profit' => $total_profit
        ]);

        foreach ($cart_list as $item) {
            $data = $request->user()->store->products()->find($item['id']);
            $sub_profit = $data->profit * $item['quantity'];
            $total_profit += $sub_profit;

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
        $transaction->Total_Profit = $total_profit;
        $transaction->save();

        return $transaction->id;
    }

    public function view_transactions_history(Request $request)
    {
        if ($request->filled(['start_date', 'end_date'])) {
            $start_date = Carbon::parse($request->query('start_date'))->startOfDay(); 
            $end_date = Carbon::parse($request->query('end_date'))->endOfDay();
            $transaction_history = $request->user()->store->transactions()->whereBetween('created_at', [$start_date, $end_date])->latest()->paginate(11);
        }
        else {
            $transaction_history = $request->user()->store->transactions()->latest()->paginate(11);
        }
        
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