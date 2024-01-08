<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Schedule</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script>
        (function () {


            //動画編集ボタン、スケジュール編集ボタン
            $(document).on('click','[name=update-movie-button],[name=create-schedule-button],[name=update-schedule-button]',function(event){
                var postURL = $(this).attr('data-href');
                location.href=postURL;
            });

            //削除ボタン
            $(document).on('click','[name=delete-schedule-button]',function(event){
                // event.preventDefault();
                var postURL = $(this).attr('data-href');
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
            @php
                $rowCheck = "";
                $row = 0;
            @endphp

            @foreach ($schedules as $schedule)

            @php
                $row = $schedule->movie_id;
            @endphp

            @if($rowCheck != $row)
            </table>
            <h2>{{ $schedule->movies->title }}（{{ $schedule->movie_id }}）</h2>
            <button data-href="/admin/movies/{{ $schedule->movie_id }}/edit" name="update-movie-button">動画情報編集</button>
            <button data-href="/admin/movies/{{ $schedule->movie_id }}/schedules/create" name="create-schedule-button">スケジュール新規作成</button>
            <table class="table">
                <tr>
                <th>ID</th>
                <th>動画ID</th>
                <th>動画タイトル</th>
                <th>上映開始時刻</th>
                <th>上映終了時刻</th>
                <th>登録日時</th>
                <th>更新日時</th>
                <th>スケジュール編集</th>
                <th>スケジュール削除</th>
                </tr>
            @endif
                <tr>
                <td>{{ $schedule->id }}</td>
                <td>{{ $schedule->movie_id }}</td>
                <td>{{ $schedule->movies->title }}</td>
                <td>{{ $schedule->start_time }}</td>
                <td>{{ $schedule->end_time }}</td>
                <td>{{ $schedule->created_at }}</td>
                <td>{{ $schedule->updated_at }}</td>
                <td><button data-href="/admin/schedules/{{ $schedule->id }}/edit" name="update-schedule-button">編集</button></td>
                <td><button data-href="/admin/schedules/{{ $schedule->id }}/destroy" name="delete-schedule-button">削除</button></td>
                </tr>
            @php
                if($rowCheck != $row){
                    $rowCheck = $row;
                }
            @endphp

            @endforeach
        </table>
    </ul>

    <div class="delete_check_dialog" style="display:none;">削除します。よろしいですか？</div>
</body>
</html>