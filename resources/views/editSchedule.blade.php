<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>updateSchedule</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <a href="/admin/schedules">スケジュール一覧へ戻る</a>
    @if ($errors->any())  
        <ul>  
            @foreach ($errors->all() as $error)  
                <li>{{ $error }}</li>  
            @endforeach  
        </ul>  
    @endif  
    <ul>
        <form method="POST" action="./update" name="update-form" >
        @method('PATCH')
        @csrf
        <table class="table">
            <tr>
            <th>スケジュールID</th>
            <th>動画ID</th>
            <th>開始日付</th>
            <th>開始時刻</th>
            <th>終了日付</th>
            <th>終了時刻</th>
            </tr>
            @foreach ($schedules as $schedule)
            <tr>
                <td><input type="hidden" name="id" value="{{ $schedule->id }}">{{ $schedule->id }}</td>
                <td><input type="hidden" name="movie_id" value="{{ $schedule->movie_id }}">{{ $schedule->movie_id }}</td>
                <td><input type="text" name="start_time_date" value="{{ $schedule->start_time->format('Y-m-d') }}"></td>
                <td><input type="text" name="start_time_time" value="{{ $schedule->start_time->format('H:i') }}"></td>
                <td><input type="text" name="end_time_date" value="{{ $schedule->end_time->format('Y-m-d') }}"></td>
                <td><input type="text" name="end_time_time" value="{{ $schedule->end_time->format('H:i') }}"></td>
            </tr>
            @endforeach
        </table>
        
        <input type="submit" name="update-button">
        </form>
        
    </ul>
</body>
</html>