<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>createReservation</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script>
        (function () {

            //予約処理
            $(document).on('click','[name=reservation-store-button]',function(event){
                event.preventDefault();
                $('#create-reservation-form').submit();
            });

        }());
    </script>
</head>
<body>
    <h2>座席予約画面</h2><br>
    <h3>{{$movie->title}}（{{$schedule->start_time->format('Y年m月d日h時i分')}} ～ {{$schedule->end_time->format('Y年m月d日h時i分')}}）</h3><br>
    <p>予約する情報を入力してください。</p><br>
    @if ($errors->any())  
        <ul>  
            @foreach ($errors->all() as $error)  
                <li>{{ $error }}</li>  
            @endforeach  
        </ul>  
    @endif  
    <ul>
        <form method="POST" action="/reservations/store" id="create-reservation-form" >
        @csrf
            <table class="table">
                <tr>
                <th>座席番号</th>
                <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
                </tr>
                
                <tr>
                <th>名前</th>
                <td><input type="text" name="name" value="{{ old('name') }}" /></td>
                </tr>

                <tr>
                <th>メールアドレス</th>
                <td><input type="text" name="email" value="{{ old('email') }}" /></td>
                </tr>

                <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                <input type="hidden" name="sheet_id" value="{{ $sheet->id }}">
                <input type="hidden" name="date" value="{{ request()->query('date') }}">
            </table>
        </form>
    </ul>
    <button name="reservation-store-button">座席を予約する</button>

</body>
</html>