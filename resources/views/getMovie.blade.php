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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <script>
        (function() {

            //検索ボタン
            $(document).on('click', '#search-button', function(event) {
                $('#search-form').submit();
            });

            //詳細ボタン
            $(document).on('click', '[name=detail-button]', function(event) {
                var postURL = $(this).attr('data-href');
                location.href = postURL;
            });

        }());
    </script>
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('映画一覧') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <form method="GET" action="" id="search-form">
                            検索：<input type="text" name="keyword" /><br>
                            <input type="radio" name="is_showing" value="-1" checked>すべて</input>
                            <input type="radio" name="is_showing" value="0">公開予定</input>
                            <input type="radio" name="is_showing" value="1">公開中</input><br>
                            <button type="button" id="search-button" class="bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">検索</button><br><br>
                        </form>

                        <ul>
                            <table class="table-fixed" style="width: 100%;">
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
                                    <th>映画詳細</th>
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
                                    <td>
                                        <!--{{ $movie->image_url }}<br>--><img src="{{ $movie->image_url }}" style="max-width:100px;"></td>
                                    <td>{{ $movie->published_year }}</td>
                                    <td>{{ $isShowingView }}</td>
                                    <td>{{ $movie->description }}</td>
                                    <td>{{ $movie->name }}</td>
                                    <td>{{ $movie->created_at }}</td>
                                    <td>{{ $movie->updated_at }}</td>
                                    <td><button data-href="/movies/{{ $movie->id }}" name="detail-button" class="bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">詳細</button></td>
                                </tr>
                                @endforeach
                            </table>
                        </ul>
                        {{ $movies->links() }}

                        <div class="delete_check_dialog" style="display:none;">削除します。よろしいですか？</div>


                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>

</html>