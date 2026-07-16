<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST" action="/products/{{ $id }}/update">
    @csrf
    @method('PUT')
        <label for="category">Choose the Category:</label>
        <select name="category" id="category">
            <option value="drinks">Drinks</option>
            <option value="snacks" selected>Snacks</option>
        </select>
        <input type="text"><button>Add a new Category</button><br><br>

        <label>product name:</label>
        <input type="text" name="name"><br><br>
        <label>product price:</label>
        <input type="number" name="price"><br><br>
        <button type="submit">Update Product</button>
    </form>
</body>
</html>