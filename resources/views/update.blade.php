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
            @foreach ($cat as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
                <option value="{{ $sel_cat_id }}" selected>{{ $sel_cat_name }}</option>
        </select><br><br>
    
        <label>product name:</label>
        <input type="text" name="name" value="{{ $user }}"><br><br>
        <label>product price:</label>
        <input type="number" name="price" value="{{ $price }}"><br><br>
        <button type="submit">Save Product</button>
    </form>
</body>
</html>