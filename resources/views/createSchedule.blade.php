<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>createSchedule</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
</head>
<body>
    <a href="./">一覧へ戻る</a>
    @if ($errors->any())  
        <ul>  
            @foreach ($errors->all() as $error)  
                <li>{{ $error }}</li>  
            @endforeach  
        </ul>  
    @endif  
    <ul>
        <form method="POST" action="./store" name="create-form" >
        <table class="table">
            <tr>
            <th>スクリーン</th>
            <th>開始日付</th>
            <th>開始時刻</th>
            <th>終了日付</th>
            <th>終了時刻</th>
            </tr>
                @method('PATCH')
                @csrf
                <tr>
                <td>
                    <select id="screen_id" name="screen_id" >
                        <option value="0">スクリーンを選択してください</option>
                        @foreach ($screens as $screen)
                        <option value="{{ $screen->id }}" >{{ $screen->name }}</option>
                        @endforeach
                    </select>
                </td>
                <td><input type="text" name="start_time_date" value="{{ old('start_time_date') }}"></td>
                <td><input type="text" name="start_time_time" value="{{ old('start_time_time') }}"></td>
                <td><input type="text" name="end_time_date" value="{{ old('end_time_date') }}"></td>
                <td><input type="text" name="end_time_time" value="{{ old('end_time_time') }}"></td>
            </tr>
        </table>
        <input type="hidden" name="movie_id" value="{{ $movie_id }}">
        <input type="submit" name="create-button">
        </form>
        
    </ul>
</body>
</html>