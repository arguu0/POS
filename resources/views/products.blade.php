<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/js/app.js'])
</head>
<body>
    
    <div>

       <p>Total in cart = <span id='cart-counter'>0</span></p>
       <button><a href="/cart">View Cart</a></button>

    </div>

    @foreach ($products as $item)
        
        <p>Product Name: <span id='item_name'>{{  $item->name }}</span> , Price: <span id='item_price'>{{ $item->price }}</span> Kyats</p>

        <div style="display: flex; gap:10px;">
            <button id="add_to_cart_btn" data-id="{{ $item->id }}" data-name="{{ $item->name }}" data-price="{{ $item->price }}">Add to cart</button>
            

            <button><a style="color: black; text-decoration: none;" href="/products/{{ $item->id }}/update">Edit</a></button>

            <form method="POST" action="/products/{{ $item->id }}/delete">
            @csrf
            @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    @endforeach

</body>
</html>