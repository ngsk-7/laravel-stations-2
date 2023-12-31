<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>createMovie</title>
</head>
<body>
    <a href="../movies">一覧へ戻る</a>
    <ul>
        <form method="POST" action="./store" name="create-form" >
        <table border="1">
            <tr>
            <th>映画タイトル</th>
            <th>画像URL</th>
            <th>公開年</th>
            <th>上映中かどうか</th>
            <th>概要</th>
            </tr>
                @method('PATCH')
                @csrf
                <tr>
                <td><input type="text" name="title" value=""></td>
                <td><input type="text" name="image_url" value=""></td>
                <td><input type="text" name="published_year" value="" maxlength="9"></td>
                <td><input type="hidden" name="is_showing" value="0"><input type="checkbox" name="is_showing" value="1"></td>
                <td><textarea name="description"></textarea></td>
            </tr>
        </table>
        <input type="submit" name="create-button">
        </form>
        
    </ul>
</body>
</html>