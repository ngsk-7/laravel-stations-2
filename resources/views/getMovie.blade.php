<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie</title>
</head>
<body>
    <ul>
        <table border="1">
            <tr>
            <th>ID</th>
            <th>タイトル</th>
            <th>画像</th>
            <th>登録日時</th>
            <th>更新日時</th>
            </tr>
            @foreach ($movies as $movie)
            <tr>
            <td>{{ $movie->id }}</td>
            <td>{{ $movie->title }}</td>
            <td>{{ $movie->image_url }}<img src="{{ $movie->image_url }}"></td>
            <td>{{ $movie->created_at }}</td>
            <td>{{ $movie->updated_at }}</td>
            </tr>
            @endforeach
        </table>
    </ul>
</body>
</html>