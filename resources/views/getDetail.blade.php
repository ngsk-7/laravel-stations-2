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
    <script>
        (function() {
            //座席を予約するボタン
            $(document).on('click', '[name=reservation-button]', function(event) {
                var postURL = $(this).attr('data-href') + '?date=' + $('#now-date').val();
                location.href = postURL;
            });

        }());
    </script>
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('映画詳細') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <ul>
                            <form method="POST" action="./update" name="update-form">
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
                                    $isShowingView = "上映中";
                                    }else if($isShowing == 0){
                                    $isShowingView = "上映予定";
                                    }

                                    @endphp
                                    @method('PATCH')
                                    @csrf
                                    <tr>
                                        <td>{{ $movie->id }}</td>
                                        <td>{{ $movie->title }}</td>
                                        <td><img src="{{ $movie->image_url }}" style="max-width:100px;"></td>
                                        <td>{{ $movie->published_year }}</td>
                                        <td>{{ $isShowingView }}</td>
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
                                    <th>スクリーンID</th>
                                    <th>上映開始時刻</th>
                                    <th>上映終了時刻</th>
                                    <th>予約</th>
                                    <th>登録日時</th>
                                    <th>更新日時</th>
                                </tr>
                                @foreach ($schedules as $schedule)

                                @method('PATCH')
                                @csrf
                                <tr>
                                    <td>{{ $schedule->id }}</td>
                                    <td>{{ $schedule->movie_id }}</td>
                                    <td>{{ $schedule->screen_id }}</td>
                                    <td>{{ $schedule->start_time }}</td>
                                    <td>{{ $schedule->end_time }}</td>
                                    <td><button data-href="/movies/{{ $schedule->movie_id }}/schedules/{{ $schedule->id }}/sheets" name="reservation-button" class="bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">座席を予約する</button></td>
                                    <td>{{ $schedule->created_at }}</td>
                                    <td>{{ $schedule->updated_at }}</td>
                                </tr>
                                @endforeach
                            </table>

                        </ul>
                        <input type="hidden" id="now-date" value="{{now()->format('Y-m-d')}}">

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>

</html>