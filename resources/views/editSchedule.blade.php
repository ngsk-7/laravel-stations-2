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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('スケジュール情報編集') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        <ul>
                            <form method="POST" action="./update" name="update-form">
                                @method('PATCH')
                                @csrf
                                <table class="table-auto border-collapse">
                                    <tr>
                                        <th>スケジュールID</th>
                                        <th>動画ID</th>
                                        <th>スクリーン</th>
                                        <th>開始日付</th>
                                        <th>開始時刻</th>
                                        <th>終了日付</th>
                                        <th>終了時刻</th>
                                    </tr>
                                    @foreach ($schedules as $schedule)
                                    <tr>
                                        <td><input type="hidden" name="id" value="{{ $schedule->id }}">{{ $schedule->id }}</td>
                                        <td><input type="hidden" name="movie_id" value="{{ $schedule->movie_id }}">{{ $schedule->movie_id }}</td>

                                        <td>
                                            <select id="screen_id" name="screen_id">
                                                <option value="0">スクリーンを選択してください</option>
                                                @foreach ($screens as $screen)
                                                @php
                                                $selected = "";
                                                if($schedule->screen_id == $screen->id ){
                                                $selected = "selected";
                                                }
                                                @endphp
                                                <option value="{{ $screen->id }}" {{ $selected }}>{{ $screen->name }}</option>
                                                @endforeach
                                            </select>
                                        </td>

                                        <td><input type="text" name="start_time_date" value="{{ $schedule->start_time->format('Y-m-d') }}"></td>
                                        <td><input type="text" name="start_time_time" value="{{ $schedule->start_time->format('H:i') }}"></td>
                                        <td><input type="text" name="end_time_date" value="{{ $schedule->end_time->format('Y-m-d') }}"></td>
                                        <td><input type="text" name="end_time_time" value="{{ $schedule->end_time->format('H:i') }}"></td>
                                    </tr>
                                    @endforeach
                                </table>

                                <input type="submit" name="update-button" class="bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">
                            </form>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>

</html>