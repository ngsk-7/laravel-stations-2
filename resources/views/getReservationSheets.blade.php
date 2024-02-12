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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <script>
        (function() {

            //座席選択時
            $(document).on('click', '[name=reservation-create-button]', function(event) {
                event.preventDefault();
                var date = $('[name=date]').val();
                var sheetId = $(this).parent().find('[name=sheet-id]').val();
                var postURL = 'reservations/create?date=' + date + '&sheetId=' + sheetId;
                location.href = postURL;
            });



            //座席取得処理
            // $(document).on('click','[name=reservation-create-button]',function(event){
            //     event.preventDefault();
            //     var date = $('[name=date]').val();
            //     var sheetRow = $(this).parent().find('[name=sheet-row]').val();
            //     var sheetColumn = $(this).parent().find('[name=sheet-column]').val();
            //     var scheduleId = $('[name=schedule_id]').val();
            //     var postAjaxURL = 'reservations/getSheetId?sheetRow=' + sheetRow + '&sheetColumn=' + sheetColumn + '&scheduleId=' + scheduleId;

            //     $.ajax({
            //         type: "get", //HTTP通信の種類
            //         url: postAjaxURL,
            //         dataType: "json"
            //     })
            //     //通信が成功したとき
            //     .done((res) => { 
            //     $.each(res, function (index, value) {
            //         console.log(res);

            //         var sheetArray = res.sheets;
            //         var sheetId = 0;
            //         //どこかのスクリーンで空席が存在したら、予約作成画面に遷移
            //         if(sheetArray.length > 0){
            //             sheetId = sheetArray[0].id;
            //             var postURL = 'reservations/create?date=' + date + '&sheetId=' + sheetId;
            //             location.href=postURL;
            //         }

            //     });
            //     })
            //     //通信が失敗したとき
            //     .fail((error) => {
            //     console.log(error.statusText);
            //     });

            // });

        }());
    </script>
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('座席選択') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <h3 class="text-xl">{{$movie->title}}（{{$schedule->start_time->format('Y年m月d日h時i分')}} ～ {{$schedule->end_time->format('Y年m月d日h時i分')}}）</h3><br>
                        <p>予約する座席を選択してください。</p><br>
                        <ul>
                            @php
                            $rowCheck = "";
                            @endphp
                            <table class="table-fixed">
                                <tr>
                                    <th class="border px-4 py-2 bg-slate-400">・</th>
                                    <th class="border px-4 py-2 bg-slate-400">・</th>
                                    <th class="border px-4 py-2 bg-slate-400">スクリーン</th>
                                    <th class="border px-4 py-2 bg-slate-400">・</th>
                                    <th class="border px-4 py-2 bg-slate-400">・</th>
                                </tr>

                                <tr>
                                    @foreach ($sheets as $sheet)

                                    @php
                                    $row = $sheet->row;
                                    $reservationCheckflag = true;
                                    if(($sheet->reservation_sheet_id > 0)){
                                    $reservationCheckflag = false;
                                    }
                                    @endphp
                                    @if($rowCheck != $row)</tr>
                                <tr>@endif
                                    @php
                                    if($rowCheck != $row){
                                    $rowCheck = $row;
                                    }
                                    @endphp

                                    <td class="border px-4 py-2 hover:bg-blue-500" @if(!$reservationCheckflag) style="background-color: gray;" @endif>
                                        @if($reservationCheckflag)<a href="" name="reservation-create-button">@endif
                                            {{ $sheet->row }}-{{ $sheet->column }}
                                            @if($reservationCheckflag)</a>@endif
                                        <input type="hidden" name="sheet-id" value="{{ $sheet->id }}">
                                    </td>

                                    @endforeach
                                </tr>
                            </table>
                            <input type="hidden" name="date" value="{{ request()->query('date') }}">
                            <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>

</html>