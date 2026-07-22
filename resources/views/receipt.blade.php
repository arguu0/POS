<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
    <table border="1" cellpadding="10" cellspacing="0" width="50%">
  <!-- Header Row -->
  <tr bgcolor="#f2f2f2">
    <th>Name</th>
    <th>Price</th>
    <th>Quantity</th>
    <th>Subtotal</th>
  </tr>
  @foreach ($transaction as $item)
    <tr bgcolor="#fafafa">
        <td>{{ $item->product_name }}</td>
        <td>{{ $item->product_price }}</td>
        <td>{{ $item->product_quantity }}</td>
        <td>{{ $item->subtotal }}</td>
    </tr>
  @endforeach
  <tr>
    <td colspan="3" align="center">Total</td>
    <td>{{ $Total }}</td>
  </tr>
</table>

    
    
</body>
</html>