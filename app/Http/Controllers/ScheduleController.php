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

use Carbon\CarbonImmutable;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class ScheduleController extends Controller
{
    public function detail($id){
        $movies = Movie::where('id',$id)->get();
        $schedules = Schedule::where('movie_id',$id)->orderBy('start_time')->get();
        return view('getDetail',['movies'=>$movies,'schedules'=>$schedules]);
    }
    public function index(){
        $movies = Movie::get();
        $schedules = Schedule::orderBy('start_time')->get();
        return view('getSchedule',['movies'=>$movies,'schedules'=>$schedules]);
    }
    public function indexSingle($id){
        $movies = Movie::where('id',$id)->get();
        $schedules = Schedule::where('movie_id',$id)->orderBy('start_time')->get();
        return view('getSchedule',['movies'=>$movies,'schedules'=>$schedules]);
    }
    public function create($id){
        return view('createSchedule',['movie_id'=>$id]);
    }
    public function edit($id){
        $schedules = Schedule::where('id',$id)->orderBy('start_time')->get();
        return view('editSchedule',['schedules'=>$schedules]);
    }
    public function store(CreateScheduleRequest $request){

        $scheduleData = new Schedule;
        $startTimeDate = $request->input('start_time_date');
        $startTimeTime = $request->input('start_time_time');
        $startTime = new CarbonImmutable($startTimeDate . ' ' . $startTimeTime);
        $endTimeDate = $request->input('end_time_date');
        $endTimeTime = $request->input('end_time_time');
        $endTime = new CarbonImmutable($endTimeDate . ' ' . $endTimeTime);

        DB::beginTransaction();
        try {
            $scheduleData->fill([
                $scheduleData->movie_id = $request->input('movie_id'),
                $scheduleData->start_time = $startTime,
                $scheduleData->end_time = $endTime,
            ])->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            abort(500);
        }

        return redirect(route('admin.movies'));

    }
    public function update(UpdateScheduleRequest $request){
        $id = $request->id;

        $scheduleData = Schedule::find($id);
        $startTimeDate = $request->input('start_time_date');
        $startTimeTime = $request->input('start_time_time');
        $startTime = new CarbonImmutable($startTimeDate . ' ' . $startTimeTime);
        $endTimeDate = $request->input('end_time_date');
        $endTimeTime = $request->input('end_time_time');
        $endTime = new CarbonImmutable($endTimeDate . ' ' . $endTimeTime);

        DB::beginTransaction();
        try {
            $scheduleData->fill([
                $scheduleData->movie_id = $request->input('movie_id'),
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