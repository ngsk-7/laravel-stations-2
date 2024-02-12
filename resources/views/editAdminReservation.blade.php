<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>editAdminReservation</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script type="text/javascript" src="{{ asset('/script/dateformat.js') }}"></script>
    <script>
        (function() {

            //日時取得処理
            $(document).on('change', '#movie_id', function() {
                $.ajax({
                        type: "get", //HTTP通信の種類
                        url: "/admin/reservations/getScheduleList",
                        dataType: "json",
                        data: {
                            'movie_id': $('#movie_id').val(),
                        }
                    })
                    //通信が成功したとき
                    .done((res) => {
                        $.each(res, function(index, value) {
                            console.log(res);
                            $('#schedule_id').empty();
                            var dateFormat = new DateFormat("yyyy/MM/dd HH:mm:ss");
                            var scheduleListHtml = '<option value="0">日時を選択してください</option>';
                            var schedulesArray = res.schedules;
                            for (var i = 0; i < schedulesArray.length; i++) {
                                var scheduleInfo = schedulesArray[i];
                                var scheduleID = scheduleInfo.id;
                                var startTime = dateFormat.format(new Date(scheduleInfo.start_time));
                                var endTime = dateFormat.format(new Date(scheduleInfo.end_time));
                                var timeHtml = startTime + "～" + endTime;
                                scheduleListHtml += '<option value="' + scheduleID + '">' + timeHtml + '</option>';
                            }
                            $('#schedule_id').html(scheduleListHtml);

                        });
                    })
                    //通信が失敗したとき
                    .fail((error) => {
                        console.log(error.statusText);
                    });

            });

            //座席取得処理
            $(document).on('change', '#schedule_id', function() {
                $.ajax({
                        type: "get", //HTTP通信の種類
                        url: "/admin/reservations/getSheetList",
                        dataType: "json",
                        data: {
                            'movie_id': $('#movie_id').val(),
                            'schedule_id': $('#schedule_id').val(),
                        }
                    })
                    //通信が成功したとき
                    .done((res) => {
                        $.each(res, function(index, value) {
                            console.log(res);
                            $('#sheet_id').empty();
                            var sheetListHtml = '<option value="0">座席を選択してください</option>';
                            var sheetArray = res.sheets;
                            for (var i = 0; i < sheetArray.length; i++) {
                                var sheetInfo = sheetArray[i];
                                var sheetID = sheetInfo.id;
                                var sheetReservationID = sheetInfo.reservations_id;
                                var column = sheetInfo.column;
                                var row = sheetInfo.row;
                                var sheetHtml = row + "-" + column;

                                if (sheetReservationID > 0) {
                                    //予約あり
                                } else {
                                    //予約なし
                                    sheetListHtml += '<option value="' + sheetID + '">' + sheetHtml + '</option>';
                                }
                            }
                            $('#sheet_id').html(sheetListHtml);

                        });
                    })
                    //通信が失敗したとき
                    .fail((error) => {
                        console.log(error.statusText);
                    });

            });

            //予約情報の更新処理
            $(document).on('click', '[name=reservation-update-button]', function(event) {
                event.preventDefault();
                $('#update-reservation-form').submit();
            });

        }());
    </script>
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('予約情報編集') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <p>予約する情報を入力してください。</p><br>
                        @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        <ul>
                            <form method="POST" action="/admin/reservations/{{ $reservation->id }}" id="update-reservation-form">
                                @csrf
                                @method('PUT')
                                <table class="table">
                                    <tr>
                                        <th>映画</th>
                                        <td>
                                            <select id="movie_id" name="movie_id">
                                                <option value="0">映画を選択してください</option>
                                                @foreach ($movies as $movie)
                                                @php
                                                $selected = "";
                                                if($reservation->movie_id == $movie->id ){
                                                $selected = "selected";
                                                }
                                                @endphp
                                                <option value="{{ $movie->id }}" {{ $selected }}>{{ $movie->title }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>日時</th>
                                        <td>
                                            <select id="schedule_id" name="schedule_id">
                                                <option value="0">日時を選択してください</option>
                                                @foreach ($schedules as $schedule)
                                                @php
                                                $selected = "";
                                                if($reservation->schedule_id == $schedule->id ){
                                                $selected = "selected";
                                                }
                                                @endphp
                                                <option value="{{ $schedule->id }}" {{ $selected }}>{{ $schedule->start_time }}～{{ $schedule->end_time }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>座席番号</th>
                                        <td>
                                            <select id="sheet_id" name="sheet_id">
                                                <option value="0">座席を選択してください</option>
                                                @foreach ($sheets as $sheet)
                                                @php
                                                $selected = "";
                                                if($reservation->sheet_id == $sheet->id ){
                                                $selected = "selected";
                                                }
                                                @endphp
                                                <option value="{{ $sheet->id }}" {{ $selected }}>{{ $sheet->row }}-{{ $sheet->column }}</option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>名前</th>
                                        <td><input type="text" name="name" value="{{ $reservation->name }}" /></td>
                                    </tr>

                                    <tr>
                                        <th>メールアドレス</th>
                                        <td><input type="text" name="email" value="{{ $reservation->email }}" /></td>
                                    </tr>

                                    <input type="hidden" name="id" value="{{ $reservation->id }}">
                                    <input type="hidden" name="date" value="{{now()->format('Y-m-d')}}">
                                </table>
                            </form>
                        </ul>
                        <button name="reservation-update-button" class="bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">予約情報を更新する</button>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>

</html>