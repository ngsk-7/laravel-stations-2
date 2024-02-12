<?php

namespace App\Http\Controllers;

// use App\Models\Movie;
// use App\Models\Genre;
// use App\Http\Requests\CreateMovieRequest;
// use App\Http\Requests\UpdateMovieRequest;
// use App\Http\Requests\CreateScheduleRequest;
// use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Requests\CreateReservationRequest;
use App\Http\Requests\CreateAdminReservationRequest;
use App\Http\Requests\UpdateAdminReservationRequest;
use App\Models\Movie;
use App\Models\Schedule;
use App\Models\Sheet;
use App\Models\Reservation;
use App\Models\Screen;
use Illuminate\Support\Facades\Auth;

use Carbon\CarbonImmutable;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class ReservationController extends Controller
{

    //予約座席一覧画面
    public function sheets($movieID,$scheduleID){
        $date = request()->query('date');
        if(request()->has('date')){
            $sheets = DB::table('sheets')
            ->select('sheets.*', 'reservations.sheet_id as reservation_sheet_id')
            ->join('screens','sheets.screen_id','=','screens.id')
            ->join('schedules', function ($join) use($scheduleID) {
                $join->on('screens.id', '=', 'schedules.screen_id')->where('schedules.id', '=', $scheduleID);
            })
            ->leftJoin('reservations', function ($join) use($scheduleID) {
                $join->on('sheets.id', '=', 'reservations.sheet_id')->where('reservations.schedule_id', '=', $scheduleID);
            })

            ->get();

            $movie = Movie::where('id',$movieID)->first();
            $schedule = Schedule::where('id',$scheduleID)->first();
            return view('getReservationSheets',['sheets'=>$sheets,'movie'=>$movie,'schedule'=>$schedule]);
        }else{
            abort(400);
        }
    }

    //予約一覧画面
    public function index(){
        
        $reservations = Reservation::whereHas('schedule', function($query) {
            $query->where('start_time','>',now());
        })->with('sheet.screen')->with('schedule.movie')->get();

        return view('getReservation',['reservations'=>$reservations]);
    }

    //予約新規作成画面
    public function reservationsCreate($movieID,$scheduleID){
        $date = request()->query('date');
        $sheetID = request()->query('sheetId');
        $auths = Auth::user();
        if(request()->has('date') && request()->has('sheetId')){

            $sheet = DB::table('sheets')
            ->select('sheets.*','reservations.sheet_id')
            ->leftJoin('reservations', function ($join) use($scheduleID) {
                $join->on('sheets.id', '=', 'reservations.sheet_id')->where('reservations.schedule_id', '=', $scheduleID);
            })
            ->where('sheets.id',$sheetID)
            ->first();

            if($sheet->sheet_id > 0){
                abort(400);
            }

            $movie = Movie::where('id',$movieID)->first();
            $schedule = Schedule::where('id',$scheduleID)->first();
            return view('createReservation',['sheet'=>$sheet,'movie'=>$movie,'schedule'=>$schedule,'auths' => $auths]);
        }else{
            abort(400);
        }
    }

    //予約新規作成画面（admin）
    public function reservationsAdminCreate(){

            $movie = Movie::get();
            return view('createAdminReservation',['movies'=>$movie]);

    }

    //Ajaxデータ取得用処理　上映スケジュール取得処理
    public function getScheduleList(){
        $movieID = request()->query('movie_id');
        $schedule = Schedule::where('movie_id',$movieID)->where('start_time','>',now())->get();
        return ['schedules'=>$schedule];

    }

    //Ajaxデータ取得用処理　座席取得処理
    public function getSheetList(){
        $movieID = request()->query('movie_id');
        $scheduleID = request()->query('schedule_id');
        $sheets = DB::table('sheets')
        ->select('sheets.*','reservations.id as reservations_id')
        ->join('schedules', function ($join) use($scheduleID,$movieID) {
            $join->on('sheets.screen_id', '=', 'schedules.screen_id')->where('schedules.id', '=', $scheduleID)->where('schedules.movie_id', '=', $movieID);
        })
        ->leftJoin('reservations', function ($join) use($scheduleID) {
            $join->on('sheets.id', '=', 'reservations.sheet_id')->on('schedules.id', '=', 'reservations.schedule_id')->where('reservations.schedule_id', '=', $scheduleID);
        })
        ->get();

        return ['sheets'=>$sheets];
    }


    //予約情報更新画面
    public function edit($id){
        
        $reservationsQuery = DB::table('reservations')
        ->select('reservations.*','movies.id AS movie_id','movies.title','sheets.id AS sheet_id','sheets.column','sheets.row','schedules.id AS schedule_id','schedules.start_time','schedules.end_time','schedules.screen_id')
        ->join('schedules','reservations.schedule_id','=','schedules.id')
        ->join('sheets','reservations.sheet_id','=','sheets.id')
        ->join('movies','schedules.movie_id','=','movies.id')
        ->where('reservations.id',$id)
        ->first();

        $screenID = $reservationsQuery->screen_id;
        $movieID = $reservationsQuery->movie_id;
        $scheduleID = $reservationsQuery->schedule_id;
        
        $movies = Movie::get();
        $schedules = Schedule::where('movie_id',$movieID)->where('start_time','>',now())->get();
        $sheets = DB::table('sheets')
        ->select('sheets.*','reservations.id as reservations_id')
        ->join('schedules', function ($join) use($scheduleID) {
            $join->on('sheets.screen_id', '=', 'schedules.screen_id')->where('schedules.id', '=', $scheduleID);
        })
        ->leftJoin('reservations', function ($join) use($scheduleID) {
            $join->on('sheets.screen_id', '=', 'reservations.id')->where('reservations.schedule_id', '=', $scheduleID);
        })
        ->get();

        return view('editAdminReservation',['reservation'=>$reservationsQuery,'movies'=>$movies,'schedules'=>$schedules,'sheets'=>$sheets]);
    }
    






    //予約情報新規作成処理
    public function reservationsStore(CreateReservationRequest $request){

        $reservationData = new Reservation;
        $count = Reservation::where('schedule_id',$request->input('schedule_id'))->where('sheet_id',$request->input('sheet_id'))->get()->count();

        if($count == 0){
            DB::beginTransaction();
            try {
                $reservationData->fill([
                    $reservationData->date = $request->input('date'),
                    $reservationData->user_id = $request->input('user_id'),
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
    
            return redirect(route('user.movies'));
        }else{
            return back()->withInput();
        }
    }

    //予約情報新規作成処理（admin）
    public function adminReservationsStore(CreateAdminReservationRequest $request){

        $reservationData = new Reservation;
        $count = Reservation::where('schedule_id',$request->input('schedule_id'))->where('sheet_id',$request->input('sheet_id'))->get()->count();

        $date = now();
        if($count == 0){
            DB::beginTransaction();
            try {
                $reservationData->fill([
                    $reservationData->date = $date,
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
    
            return redirect(route('admin.reservations'));
        }else{
            return back()->withInput();
        }

    }


    //予約情報更新処理
    public function update($reservations_id,UpdateAdminReservationRequest $request){
        $id = $reservations_id;
        $reservationData = Reservation::find($id);

        $date = now();
            DB::beginTransaction();
            try {
                $reservationData->fill([
                    $reservationData->date = $date,
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
    
            return redirect(route('admin.reservations'));

    }

    //予約情報削除処理
    public function destroy($id){
        $reservationData = Reservation::find($id);
        $reservationDataExists = Reservation::where('id',$id)->exists();
        if($reservationDataExists){
            $reservationData->delete();
        }else{
            abort(404);
        }
        return redirect(route('admin.reservations'));
    }
}