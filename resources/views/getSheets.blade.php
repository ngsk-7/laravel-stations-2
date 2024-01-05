<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sheets</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script>
        (function () {

            // //検索ボタン
            // $(document).on('click','#search-button',function(event){
            //     $('#search-form').submit();
            // });

            // //新規作成ボタン
            // $(document).on('click','[name=create-button]',function(event){
            //     var postURL = $(this).attr('data-href');
            //     location.href=postURL;
            // });

            // //更新ボタン
            // $(document).on('click','[name=update-button]',function(event){
            //     var postURL = $(this).attr('data-href');
            //     location.href=postURL;
            // });

            // //削除ボタン
            // $(document).on('click','[name=delete-button]',function(event){
            //     // event.preventDefault();
            //     var postURL = $(this).attr('data-href');
            //     $(".delete_check_dialog").dialog({
            //         title:"確認",
            //         buttons:{
            //             "キャンセル":function(){
            //                 $(this).dialog("close");
            //             },
            //             "実行":function(){
            //                 location.href=postURL;
            //             },
            //         },

            //     });
            // });



        }());
    </script>
</head>
<body>
    <!-- <form method="GET" action="" id="search-form" >
        検索：<input type="text" name="keyword" /><br>
        <input type="radio" name="is_showing" value="-1" checked>すべて</input>
        <input type="radio" name="is_showing" value="0">公開予定</input>
        <input type="radio" name="is_showing" value="1">公開中</input><br>
        <button type="button" id="search-button">検索</button><br><br>
    </form> -->
    <!-- <button data-href="/admin/movies/create" name="create-button">新規作成</button> -->
    <ul>
        @php
            $rowCheck = "";
        @endphp
        <table class="table">
            <tr>
            <th>・</th>
            <th>・</th>
            <th>スクリーン</th>
            <th>・</th>
            <th>・</th>
            </tr>
            
            <tr>
            @foreach ($sheets as $sheet)

            @php
                $row = $sheet->row;
            @endphp
            @if($rowCheck != $row)</tr><tr>@endif
            @php
                if($rowCheck != $row){
                    $rowCheck = $row;
                }
            @endphp

            <td>{{ $sheet->row }}-{{ $sheet->column }}</td>

            @endforeach
            </tr>
        </table>
    </ul>

    <!-- <div class="delete_check_dialog" style="display:none;">削除します。よろしいですか？</div> -->
</body>
</html>