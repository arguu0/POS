<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    @vite(['resources/js/cart.js'])
</head>
<body>
    <h3>My Cart</h3>
    
    <p id='show_all'></p>

    <p>Total = <span id='total'>0</span> Kyats</p>


    <form method="POST" action="/cart/transaction">
    @csrf
        <p id="to_server"></p>
        <p id='length'></p>
        <button id='clear_ls'>Create Receipt</button>
    </form>
</body>
</html>