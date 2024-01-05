<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>getDetail</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <a href="./">一覧へ戻る</a>
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
                <td>{{ $movie->id }}</td>
                <td>{{ $movie->title }}</td>
                <td><img src="{{ $movie->image_url }}" style="max-width:100px;"></td>
                <td>{{ $movie->published_year }}</td>
                <td>{{ $isShowing }}</td>
                <td>{{ $movie->description }}</td>
                <td>{{ $movie->genre->name }}</td>
                <td>{{ $movie->created_at }}</td>
                <td>{{ $movie->updated_at }}</td>
                </tr>
            @endforeach
        </table>
        <!-- <input type="submit" name="update-button"> -->
        </form>



        <table class="table">
            <tr>
            <th>ID</th>
            <th>動画ID</th>
            <th>上映開始時刻</th>
            <th>上映終了時刻</th>
            <th>登録日時</th>
            <th>更新日時</th>
            </tr>
            @foreach ($schedules as $schedule)

                @method('PATCH')
                @csrf
                <tr>
                <td>{{ $schedule->id }}</td>
                <td>{{ $schedule->movie_id }}</td>
                <td>{{ $schedule->start_time }}</td>
                <td>{{ $schedule->end_time }}</td>
                <td>{{ $schedule->created_at }}</td>
                <td>{{ $schedule->updated_at }}</td>
                </tr>
            @endforeach
        </table>

    </ul>
</body>
</html>