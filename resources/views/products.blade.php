<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>

    @foreach ($products as $item)
    
        <p>{{ $item->id }}. {{  $item->name }} , K{{ $item->price }}</p>

        <div style="display: flex; gap:10px;">
                
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