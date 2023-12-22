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
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            <th>登録日時</th>
            <th>更新日時</th>
            </tr>
            @foreach ($movies as $movie)

            @php
                $isShowing = $movie->is_showing;
                $isShowingView = "";
                if($isShowing == 1){
                    $isShowingView = "上映中";
                }else if($isShowing == 0){
                    $isShowingView = "上映予定";
                }

            @endphp
            <tr>
            <td>{{ $movie->id }}</td>
            <td>{{ $movie->title }}</td>
            <td>{{ $movie->image_url }}<img src="{{ $movie->image_url }}"></td>
            <td>{{ $movie->published_year }}</td>
            <td>{{ $isShowingView }}</td>
            <td>{{ $movie->description }}</td>
            <td>{{ $movie->created_at }}</td>
            <td>{{ $movie->updated_at }}</td>
            </tr>
            @endforeach
        </table>
    </ul>
</body>
</html>