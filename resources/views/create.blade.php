<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method='POST' action="/products/create_category">
    @csrf
        <input type="text" name="cat_name"><button type="submit">Add a new Category</button><br><br>
    </form>
    <form method="POST" action="/products/create">
    @csrf
        <label for="category">Choose the Category:</label>
        <select name="category" id="category">
            @foreach ($cat as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select><br><br>
    
        <label>product name:</label>
        <input type="text" name="name"><br><br>
        <label>product price:</label>
        <input type="number" name="price"><br><br>
        <button type="submit">Add Product</button>
    </form>
</body>
</html>