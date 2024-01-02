<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Genre;
use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

use function Psy\debug;

class MovieController extends Controller
{
    public function index(Request $request){
        $keyword = $request->query('keyword');
        $isShowing = $request->query('is_showing');

        $moviesQuery = DB::table('movies')
        ->select('movies.*','genres.name')
        ->leftJoin('genres','movies.genre_id','=','genres.id');

        if(!empty($keyword)){
            $moviesQuery->where('title','like',"%$keyword%")
            ->orWhere('description','like',"%$keyword%");
        }
        if(isset($isShowing) && ($isShowing == 0 || $isShowing == 1)){
            $moviesQuery->where('is_showing',$isShowing);
        }
        // $moviesQuery->paginate(20);
        $movies = $moviesQuery->orderBy('movies.id')->paginate(20);
        return view('getMovie',['movies'=>$movies]);
    }
    public function create(){
        // $movies = Movie::all();
        return view('createMovie');
    }
    public function edit($id){
        
        // $moviesQuery = DB::table('movies')
        // ->select('movies.*','genres.name')
        // ->leftJoin('genres','movies.genre_id','=','genres.id')
        // ->where('movies.id',$id)
        // ->get();
        // $movies = $moviesQuery;
        $movies = Movie::find($id)->get();
        return view('editMovie',['movies'=>$movies]);
    }
    public function store(UpdateMovieRequest $request){

        $movieData = new Movie;

        $genreName = $request->genre;
        $genreId = 0;

        $genresData = Genre::where('name',$genreName)->get();

        DB::beginTransaction();
        try {
            if($genresData->count() == 0){
                $genresCreateData = new Genre;
                $genresCreateData->fill([
                    $genresCreateData->name = $request->input('genre'),
                ])->save();
            }
            $genresData = Genre::where('name',$genreName)->first();
            $genreId = $genresData->id;

            $movieData->fill([
                $movieData->title = $request->input('title'),
                $movieData->image_url = $request->input('image_url'),
                $movieData->published_year = $request->input('published_year'),
                $movieData->is_showing = $request->input('is_showing'),
                $movieData->description = $request->input('description'),
                $movieData->genre_id = $genreId,
            ])->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            abort(500);
        }

        return redirect(route('admin.movies'));

    }
    public function update(UpdateMovieRequest $request){
        $id = $request->id;
        $genreName = $request->genre;
        $genreId = 0;

        $movieData = Movie::find($id);
        $genresData = Genre::where('name',$genreName)->get();
        DB::beginTransaction();
        try {
            if($genresData->count() == 0){
                $genresCreateData = new Genre;
                $genresCreateData->fill([
                    $genresCreateData->name = $request->input('genre'),
                ])->save();
            }
            $genresData = Genre::where('name',$genreName)->first();
            $genreId = $genresData->id;

            $movieData->fill([
                $movieData->title = $request->input('title'),
                $movieData->image_url = $request->input('image_url'),
                $movieData->published_year = $request->input('published_year'),
                $movieData->is_showing = $request->input('is_showing'),
                $movieData->description = $request->input('description'),
                $movieData->genre_id = $genreId,
                $movieData->updated_at = now(),
            ])->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            abort(500);
        }

        return redirect(route('admin.movies'));

    }
    public function destroy($id){
        $movieData = Movie::find($id);
        $movieDataExists = Movie::where('id',$id)->exists();
        if($movieDataExists){
            $movieData->delete();
        }else{
            abort(404);
        }
        return redirect(route('admin.movies'));
    }
}