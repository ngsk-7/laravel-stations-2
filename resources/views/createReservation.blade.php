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
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous"> -->
    <script>
        (function() {

            //予約処理
            $(document).on('click', '[name=reservation-store-button]', function(event) {
                event.preventDefault();
                $('#create-reservation-form').submit();
            });

        }());
    </script>
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('座席予約') }}
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">

                        <h3 class="text-xl">{{$movie->title}}（{{$schedule->start_time->format('Y年m月d日h時i分')}} ～ {{$schedule->end_time->format('Y年m月d日h時i分')}}）</h3><br>
                        <p>予約する情報を入力してください。</p><br>
                        @if ($errors->any())
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        @endif
                        <ul>
                            <form method="POST" action="/reservations/store" id="create-reservation-form">
                                @csrf
                                <table class="table">
                                    <tr>
                                        <th>座席番号</th>
                                        <td>{{ $sheet->row }}-{{ $sheet->column }}</td>
                                    </tr>

                                    <tr>
                                        <th>名前</th>
                                        <td>{{$auths->name}}<input type="hidden" name="name" value="{{$auths->name}}" /></td>
                                    </tr>

                                    <tr>
                                        <th>メールアドレス</th>
                                        <td>{{$auths->email}}<input type="hidden" name="email" value="{{$auths->email}}" /></td>
                                    </tr>
                                    <input type="hidden" name="user_id" value="{{$auths->id}}" />
                                    <input type="hidden" name="schedule_id" value="{{ $schedule->id }}">
                                    <input type="hidden" name="sheet_id" value="{{ $sheet->id }}">
                                    <input type="hidden" name="date" value="{{ request()->query('date') }}">
                                </table>
                            </form>
                        </ul>
                        <button name="reservation-store-button" class="bg-blue-600 hover:bg-blue-500 text-white rounded px-4 py-2">座席を予約する</button>

                    </div>
                </div>
            </div>
        </div>
    </x-app-layout>
</body>

</html>