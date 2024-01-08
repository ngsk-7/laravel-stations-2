<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>editMovie</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <a href="../">動画一覧へ戻る</a>
    <a href="/admin/schedules">スケジュール一覧へ戻る</a>
    @if ($errors->any())  
        <ul>  
            @foreach ($errors->all() as $error)  
                <li>{{ $error }}</li>  
            @endforeach  
        </ul>  
    @endif  
    <ul>
        <form method="POST" action="./update" name="update-form" >
        <table class="table">
            <tr>
            <th>ID</th>
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            <th>ジャンル</th>
            <th>登録日時</th>
            <th>更新日時</th>
            </tr>
            @foreach ($movies as $movie)

            @php
                $isShowing = $movie->is_showing;
                $isShowingView = "";
                if($isShowing == 1){
                    $isShowingView = "checked";
                }else if($isShowing == 0){
                    $isShowingView = "";
                }

            @endphp
                @method('PATCH')
                @csrf
                <tr>
                <td><input type="hidden" name="id" value="{{ $movie->id }}">{{ $movie->id }}</td>
                <td><input type="text" name="title" value="{{ $movie->title }}"></td>
                <td><input type="text" name="image_url" value="{{ $movie->image_url }}"></td>
                <td><input type="text" name="published_year" value="{{ $movie->published_year }}" maxlength="9"></td>
                <td><input type="hidden" name="is_showing" value="0"><input type="checkbox" name="is_showing" value="1" {{ $isShowingView }}></td>
                <td><textarea name="description">{{ $movie->description }}</textarea></td>
                <td><input type="text" name="genre" value="{{ $movie->genre->name }}"></td>
                <td>{{ $movie->created_at }}</td>
                <td>{{ $movie->updated_at }}</td>
                </tr>
            @endforeach
        </table>
        <input type="submit" name="update-button">
        </form>
        
    </ul>
</body>
</html>