<?php

namespace App\Http\Controllers;

// use App\Models\Movie;
// use App\Models\Genre;
// use App\Http\Requests\CreateMovieRequest;
// use App\Http\Requests\UpdateMovieRequest;
use App\Http\Requests\CreateScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Screen;

use Carbon\CarbonImmutable;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class ScheduleController extends Controller
{

    //映画詳細画面
    public function detail($id){
        $movies = Movie::where('id',$id)->get();
        $schedules = Schedule::where('movie_id',$id)->orderBy('start_time')->get();
        return view('getDetail',['movies'=>$movies,'schedules'=>$schedules]);
    }

    //スケジュール一覧画面
    public function index(){
        $movies = Movie::get();
        $schedules = Schedule::orderBy('start_time')->get();
        return view('getSchedule',['movies'=>$movies,'schedules'=>$schedules]);
    }

    //スケジュール詳細画面
    // public function indexSingle($id){
    //     $movies = Movie::where('id',$id)->get();
    //     $schedules = Schedule::where('movie_id',$id)->orderBy('start_time')->get();
    //     return view('getSchedule',['movies'=>$movies,'schedules'=>$schedules]);
    // }

    //スケジュール新規作成画面
    public function create($id){
        $screens = Screen::get();
        return view('createSchedule',['movie_id'=>$id,'screens'=>$screens]);
    }

    //スケジュール更新画面
    public function edit($id){
        $screens = Screen::get();
        $schedules = Schedule::where('id',$id)->orderBy('start_time')->get();
        return view('editSchedule',['schedules'=>$schedules,'screens'=>$screens]);
    }





    //スケジュール新規作成処理
    public function store(CreateScheduleRequest $request){

        $scheduleData = new Schedule;
        $startTimeDate = $request->input('start_time_date');
        $startTimeTime = $request->input('start_time_time');
        $endTimeDate = $request->input('end_time_date');
        $endTimeTime = $request->input('end_time_time');
        $startTime = new CarbonImmutable($startTimeDate . ' ' . $startTimeTime);
        $endTime = new CarbonImmutable($endTimeDate . ' ' . $endTimeTime);

        DB::beginTransaction();
        try {
            $scheduleData->fill([
                $scheduleData->movie_id = $request->input('movie_id'),
                $scheduleData->screen_id = $request->input('screen_id'),
                $scheduleData->start_time = $startTime,
                $scheduleData->end_time = $endTime,
            ])->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            abort(500);
        }

        return redirect(route('admin.schedules'));

    }


    //スケジュール更新処理
    public function update(UpdateScheduleRequest $request){
        $id = $request->id;

        $scheduleData = Schedule::find($id);
        $startTimeDate = $request->input('start_time_date');
        $startTimeTime = $request->input('start_time_time');
        $endTimeDate = $request->input('end_time_date');
        $endTimeTime = $request->input('end_time_time');
        $startTime = new CarbonImmutable($startTimeDate . ' ' . $startTimeTime);
        $endTime = new CarbonImmutable($endTimeDate . ' ' . $endTimeTime);

        DB::beginTransaction();
        try {
            $scheduleData->fill([
                $scheduleData->movie_id = $request->input('movie_id'),
                $scheduleData->screen_id = $request->input('screen_id'),
                $scheduleData->start_time = $startTime,
                $scheduleData->end_time = $endTime,
            ])->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            abort(500);
        }

        return redirect(route('admin.schedules'));

    }

    //スケジュール削除処理
    public function destroy($id){
        $scheduleData = Schedule::find($id);
        $scheduleDataExists = Schedule::where('id',$id)->exists();
        if($scheduleDataExists){
            $scheduleData->delete();
        }else{
            abort(404);
        }
        return redirect(route('admin.schedules'));
    }
}