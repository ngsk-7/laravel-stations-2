<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>createMovie</title>
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
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            <th>ジャンル</th>
            </tr>
                @method('PATCH')
                @csrf
                <tr>
                <td><input type="text" name="title" value="{{ old('title') }}"></td>
                <td><input type="text" name="image_url" value="{{ old('image_url') }}"></td>
                <td><input type="text" name="published_year" value="{{ old('published_year') }}" maxlength="9"></td>
                <td><input type="hidden" name="is_showing" value="0"><input type="checkbox" name="is_showing" value="1"></td>
                <td><textarea name="description">{{ old('description') }}</textarea></td>
                <td><input type="text" name="genre" value="{{ old('genre') }}"></td>
            </tr>
        </table>
        <input type="submit" name="create-button">
        </form>
        
    </ul>
</body>
</html>