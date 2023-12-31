<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Movie</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <script>
        (function () {

            $(document).on('click','[name=delete-button]',function(event){
                event.preventDefault();
                var postURL = $(this).attr('href');
                console.log(postURL);
                $(".delete_check_dialog").dialog({
                    title:"確認",
                    buttons:{
                        "キャンセル":function(){
                            $(this).dialog("close");
                        },
                        "実行":function(){
                            location.href=postURL;
                        },
                    },

                });
            });

        }());
    </script>
</head>
<body>
    <ul>
    <a href="./movies/create">新規作成</a>
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
            <th>編集</th>
            <th>削除</th>
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
            <td>{{ $movie->image_url }}<br><img src="{{ $movie->image_url }}" style="max-width:100px;"></td>
            <td>{{ $movie->published_year }}</td>
            <td>{{ $isShowingView }}</td>
            <td>{{ $movie->description }}</td>
            <td>{{ $movie->created_at }}</td>
            <td>{{ $movie->updated_at }}</td>
            <td><a href="./movies/{{ $movie->id }}/edit">編集</a></td>
            <td><a href="./movies/{{ $movie->id }}/destroy" name="delete-button">削除</a></td>
            </tr>
            @endforeach
        </table>
    </ul>

    <div class="delete_check_dialog" style="display:none;">削除します。よろしいですか？</div>
</body>
</html>