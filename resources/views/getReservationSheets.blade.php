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

            //座席選択時
            $(document).on('click','[name=reservation-create-button]',function(event){
                event.preventDefault();
                var date = $('[name=date]').val();
                var sheetId = $(this).parent().find('[name=sheet-id]').val();
                var postURL = 'reservations/create?date=' + date + '&sheetId=' + sheetId;
                location.href=postURL;
            });

        }());
    </script>
</head>
<body>
    <h2>座席選択画面</h2><br>
    <h3>{{$movie->title}}（{{$schedule->start_time->format('Y年m月d日h時i分')}} ～ {{$schedule->end_time->format('Y年m月d日h時i分')}}）</h3><br>
    <p>予約する座席を選択してください。</p><br>
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

            <td>
                <a href="" name="reservation-create-button">{{ $sheet->row }}-{{ $sheet->column }}</a>
                <input type="hidden" name="sheet-id" value="{{ $sheet->id }}">
            </td>

            @endforeach
            </tr>
        </table>
        <input type="hidden" name="date" value="{{ request()->query('date') }}">
    </ul>

</body>
</html>