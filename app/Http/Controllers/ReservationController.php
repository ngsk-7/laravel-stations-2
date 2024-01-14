<?php

namespace App\Http\Controllers;

// use App\Models\Movie;
// use App\Models\Genre;
// use App\Http\Requests\CreateMovieRequest;
// use App\Http\Requests\UpdateMovieRequest;
// use App\Http\Requests\CreateScheduleRequest;
// use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Requests\CreateReservationRequest;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\Reservation;

use Carbon\CarbonImmutable;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class ReservationController extends Controller
{
    public function sheets($movieID,$scheduleID){
        $date = request()->query('date');
        if(request()->has('date')){
            $sheets = DB::table('sheets')->get();
            $movie = Movie::where('id',$movieID)->first();
            $schedule = Schedule::where('id',$scheduleID)->first();
            return view('getReservationSheets',['sheets'=>$sheets,'movie'=>$movie,'schedule'=>$schedule]);
        }else{
            abort(400);
        }
    }
    
    public function reservationsCreate($movieID,$scheduleID){
        $date = request()->query('date');
        $sheetID = request()->query('sheetId');
        if(request()->has('date') && request()->has('sheetId')){
            $sheet = Sheet::where('id',$sheetID)->first();
            $movie = Movie::where('id',$movieID)->first();
            $schedule = Schedule::where('id',$scheduleID)->first();
            return view('createReservation',['sheet'=>$sheet,'movie'=>$movie,'schedule'=>$schedule]);
        }else{
            abort(400);
        }
    }

    public function reservationsStore(CreateReservationRequest $request){

        $reservationData = new Reservation;
        $count = Reservation::where('schedule_id',$request->input('schedule_id'))->where('sheet_id',$request->input('sheet_id'))->get()->count();

        if($count == 0){
            DB::beginTransaction();
            try {
                $reservationData->fill([
                    $reservationData->date = $request->input('date'),
                    $reservationData->schedule_id = $request->input('schedule_id'),
                    $reservationData->sheet_id = $request->input('sheet_id'),
                    $reservationData->email = $request->input('email'),
                    $reservationData->name = $request->input('name'),
                    $reservationData->is_canceled = 0,
                ])->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollback();
                abort(500);
            }
    
            return redirect(route('admin.movies'));
        }else{
            return back()->withInput();
        }

    }

    // public function detail($id){
    //     $movies = Movie::where('id',$id)->get();
    //     $schedules = Schedule::where('movie_id',$id)->orderBy('start_time')->get();
    //     return view('getDetail',['movies'=>$movies,'schedules'=>$schedules]);
    // }
    // public function index(){
    //     $movies = Movie::get();
    //     $schedules = Schedule::orderBy('start_time')->get();
    //     return view('getSchedule',['movies'=>$movies,'schedules'=>$schedules]);
    // }
    // public function indexSingle($id){
    //     $movies = Movie::where('id',$id)->get();
    //     $schedules = Schedule::where('movie_id',$id)->orderBy('start_time')->get();
    //     return view('getSchedule',['movies'=>$movies,'schedules'=>$schedules]);
    // }
    // public function create($id){
    //     return view('createSchedule',['movie_id'=>$id]);
    // }
    // public function edit($id){
    //     $schedules = Schedule::where('id',$id)->orderBy('start_time')->get();
    //     return view('editSchedule',['schedules'=>$schedules]);
    // }

    // public function update(UpdateScheduleRequest $request){
    //     $id = $request->id;

    //     $scheduleData = Schedule::find($id);
    //     $startTimeDate = $request->input('start_time_date');
    //     $startTimeTime = $request->input('start_time_time');
    //     $endTimeDate = $request->input('end_time_date');
    //     $endTimeTime = $request->input('end_time_time');
    //     $startTime = new CarbonImmutable($startTimeDate . ' ' . $startTimeTime);
    //     $endTime = new CarbonImmutable($endTimeDate . ' ' . $endTimeTime);

    //     DB::beginTransaction();
    //     try {
    //         $scheduleData->fill([
    //             $scheduleData->movie_id = $request->input('movie_id'),
    //             $scheduleData->start_time = $startTime,
    //             $scheduleData->end_time = $endTime,
    //         ])->save();
    //         DB::commit();
    //     } catch (\Exception $e) {
    //         DB::rollback();
    //         abort(500);
    //     }

    //     return redirect(route('admin.schedules'));

    // }
    // public function destroy($id){
    //     $scheduleData = Schedule::find($id);
    //     $scheduleDataExists = Schedule::where('id',$id)->exists();
    //     if($scheduleDataExists){
    //         $scheduleData->delete();
    //     }else{
    //         abort(404);
    //     }
    //     return redirect(route('admin.schedules'));
    // }
}